<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Medom Order Confirmation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="margin: 0; padding: 0; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f8f8f8; margin: 0;">
<table align="center"
       border="0"
       cellpadding="0"
       cellspacing="0"
       width="600"
       style="border-collapse: collapse; width:600px; background-color: #ffffff; color: #514d6a; padding: 50px; margin-top: 40px; line-height: 28px;"
      >
    <tr>
        <td style="text-align: center; padding: 30px">
            <img src="{{ asset('/images/logo.png') }}" alt="Medom Logo"
                 style="border:none; display:inline-block;" height="60">
        </td>
    </tr>

    <tr>
        <td style="padding: 10px 30px 0px 30px;font-weight: 300; line-height: 30px; font-size: 18px; font-family: 'Open Sans',Helvetica,Arial,sans-serif; color: #666; letter-spacing: -1px;">

            <p>Dear {{$order->first_name }}</p>
            <p>Thank you for using our service. Your flight was successfully booked and we have received
                payments to confirm the reservation.
            </p>

            <div>
                You will be travelling from <b> {{$order->from_city}} </b> to
                <b>{{$order->to_city}}</b></div>

            <h4>Flight Details:</h4>
        </td>
    </tr>
    <tr>
        <td style="padding: 20px 30px ">
            <table style="width: 100%; text-align: left; font-size: 1.1em">
                <tr>
                    <th>Booking Date</th>
                    <td>{{$order->booking_date}}</td>
                </tr>
                <tr>
                    <th>Booking ID</th>
                    <td>{{$order->booking_id}}</td>
                </tr>
               
                <tr>
                    <th>Status</th>
                    <td>{{$order->status}}</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td>{{$order->currency}} {{$order->total}}</td>
                </tr>
            </table>
        </td>
    </tr>
 
    
    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="border:none; width:600px; margin-top: 20px; margin-bottom: 40px; text-align: center; color: #85868a;">
                <tr>
                    <td style="padding-top: 20px;">
                        Copyright &copy; {{date('Y')}} Medom Limited. All Rights Reserved.
                    </td>
                </tr>

            </table>
        </td>
    </tr>

</table>
</body>
</html>