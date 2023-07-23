<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Utilities\Constant;
use App\Utilities\VNPay;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Mail;

class CheckOutController extends Controller
{

    //
    public function index()
    {
        $carts = Cart::content();
        $total = Cart::total();
        $subtotal = Cart::subtotal();
        return view('front.checkout.index', compact('carts', 'total', 'subtotal'));
    }
    public function addOrder(Request $request)
    {
        //01.Thêm đơn Hàng
        $data = $request->all();
        $data['status'] = Constant::order_status_ReceiveOrders;
        $order = Order::create($data);
        //02.Thêm đơn hàng
        $carts = Cart::content();
        foreach ($carts as $cart) {
            $data = [
                'order_id' => $order->id,
                'product_id' => $cart->id,
                'qty' => $cart->qty,
                'amount' => $cart->price,
                'total' => $cart->price * $cart->qty
            ];
            OrderDetail::create($data);
        }
        if ($request->payment_type == 'pay_later') {

            //03,gửi mail
            $total = Cart::total();
            $subtotal = Cart::subtotal();
            $this->sendEmail($order, $total, $subtotal);
            //04. xóa giỏ hàng
            Cart::destroy();
            //05.trả về kết quả
            return redirect('checkout/result')
                ->with('notification', 'Success! You will pay on delivery. Please check your email. ');
        }
        if ($request->payment_type == 'online_payment') {
            //01.lấy URL thanh toán VNPAy
            $data_url = VNPay::vnpay_create_payment([
                'vnp_TxnRef' => $order->id, //ID đơn hàng
                'vnp_OrderInfo' => 'Mô tả đơn hàng ở đây',
                'vnp_Amount' => Cart::total(0, '', '') * 23642, //nhân với tỉ giá để chuyển sang tiền việt
            ]);

            //02.Chuyển Hướng toies URRL lấy dc
            return redirect()->to($data_url);
        }
    }

    public function vnPayCheck(Request $request)
    {
        //01.lấy ddataa từ URL (do VNPAY  gửi về qua $vnp_Returnurl)

        $vnp_ResponseCode = $request->get('vnp_ResponseCode'); //Mã phản hòi kết quả thanh toán . 00 = thành công

        $vnp_TxnRef = $request->get('vnp_TxnRef'); //ticket_id

        $vnp_Amount = $request->get('vnp_Amount'); // số tiền thanh toán

        //02.kiểm tra kết quả giao dịch trả về từ VNPAy

        if ($vnp_ResponseCode != null) {

            // nếu thành công
            if ($vnp_ResponseCode == 00) {
                //Gửi email
                $order = Order::find($vnp_TxnRef);
                $total = Cart::total();
                $subtotal = Cart::subtotal();
                $this->sendEmail($order, $total, $subtotal);

                // xóa giỏ hàng
                Cart::destroy($order);

                // thông báo kết quả

                return redirect('checkout/result')
                    ->with('notification', 'Success! You will pay on delivery. Please check your email. ');
            } else {
                // nếu kh thành công
                // xóa đơn hàng đã thêm vào db
                Order::find($vnp_TxnRef)->delete();

                //và trả về thông báo lỗi
                return redirect('checkout/result')
                    ->with('notification', ' ERROR: payment failed or canceled. ');
            }
        }
    }

    public function result()
    {

        $notification = session('notification');


        return view('front.checkout.result', compact('notification'));
    }


    private function sendEmail($order, $total, $subtotal)
    {
        $email_to = $order->email;
        Mail::send('front.checkout.email', compact('order', 'total', 'subtotal'), function ($message) use ($email_to) {
            $message->from('ngocquy2412nd@gmail.com', 'Ngoc Quy');
            $message->to($email_to, $email_to);
            $message->subject('Order Notification');
        });
    }
}
