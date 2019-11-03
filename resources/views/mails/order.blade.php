<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>TravelLab - New Booking</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">
    <style>
        .default-color {
            color: #666;
        }
        .text-right{
            /*text-align: right;*/
            padding-right: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f8f8f8; margin: 0;">

<table border="0" cellpadding="0" cellspacing="0"
       style="width: 100%; background-color: #f4f8fb; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 15px;"
       bgcolor="#f8f8f8">

    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="width:600px; background-color: #ffffff; color: #514d6a; padding: 40px; margin-top: 40px; line-height: 28px;"
                   bgcolor="#ffffff">
                <tr>
                    <td style="text-align: center; vertical-align: top;">
                        <img src="{{ asset('/images/logo.png') }}" alt="Travellab Logo"
                             style="border:none; display:inline-block;" height="60">
                    </td>
                </tr>
                {{--<tr>--}}
                {{--<td style="border-bottom: 2px double #9f191f; padding-top: 10px;"></td>--}}
                {{--</tr>--}}


                <tr>
                    <td style="padding-top: 10px; font-weight: 300; line-height: 36px; font-size: 18px; font-family: 'Open Sans',Helvetica,Arial,sans-serif; color: #666; letter-spacing: -1px;">

                        <p class="default-color"><b>Dear {{$order->first_name }},</b></p>

                        <p>Thank you for using our service. Your flight was successfully booked and we have received
                            payments to confirm the reservation.
                        </p>
                        <div>
                            You will be travelling from <b>{{$order->from_city}}</b>
                            to

                            <b>{{$order->to_city}}</b></div>

                        <h4>Flight Details:</h4>
                    </td>
                </tr>

                <tr>
                    <td>
                        <table id="booking" cellpadding="0" cellspacing="0" width="100%">

                            <tr>
                                <td  class="text-right">Booking Date</td>
                                <td> {{$order->booking_date}}</td>
                            </tr>
                            <tr>
                                <td class="text-right" >
                                    Booking ID
                                </td>
                                <td><span class="h6">{{$order->booking_id}}</span></td>
                            </tr>
                            <tr>
                                <td  class="text-right">Booking Reference</td>
                                <td><span class="h5">{{$order->booking_ref }}</span></td>
                            </tr>

                            <tr>
                                <td  class="text-right">Status</td>
                                <td><span class="badge badge-danger text-capitalize">{{$order->status}}</span></td>
                            </tr>
                            <tr>
                                <td  class="h5 text-right">Total</td>
                                <td><span class="h5 text-primary">{{$order->currency}} {{$order->total}}</span></td>
                            </tr>

                        </table>
                    </td>
                </tr>
                <style>
                    .flight-header {
                        margin: 0;
                        padding: 0;
                        font-size: 14px;

                    }

                    .flight-header td {
                        padding: 10px;
                        color: #fff;
                        background:  #AD3335; padding: 20px;
                    }

                    .flight-header td:last-child {
                        text-align: right;
                    }

                    .flight-details {
                        border: 0.5px solid #F48884;
                        width: 100%;
                        font-size: 11px;
                        margin-top: 20px;
                        margin-bottom: 10px;

                    }

                    .flight-details td {
                        padding: 10px;
                    }
                    .flight-time{
                        font-size: 1.5em;
                        font-weight: bold;
                        color: #EF493A;

                        display: block;
                    }

                    .flight-date{
                        line-height: 12px;
                    }
                    .flight-airport{
                        line-height: 14px;
                        color:  #999;
                    }

                    .flight-info{
                        border-bottom: 3px solid #F48884;
                    }
                </style>
                <tr>
                    <td>
                        <table class="flight-details" border="0" cellspacing="0" cellpadding="0">
                            <tr class="flight-header" style="">
                                <td >
                                    <div class="flight-number"><b>{{$order->outbound_flight_no}}</b></div>
                                    <div class="flight-airline">{{$order->outbound_airline}}</div>
                                </td>
                                <td width="50%"><b> Outbound</b></td>
                            </tr>
                            <tr >
                                <td class="flight-info">
                                    <div class="flight-date">{{$order->out_depart_date}}</div>
                                    <span class="flight-time">{{$order->out_depart_time}}</span>
                                    <span class="flight-airport"><b>{{$order->out_depart_airport}}</b></span>
                                </td>
                                <td class="flight-info">
                                    <div class="flight-date">{{$order->out_arrival_date}}</div>
                                    <span class="flight-time">{{$order->out_arrival_time}}</span>
                                    <span class="flight-airport"><b>{{$order->out_arrival_airport}}</b></span>
                                </td>
                            </tr>
                        </table>





                        <table class="flight-details" border="0" cellspacing="0" cellpadding="0">
                            <tr class="flight-header" style="">
                                <td>
                                    <div class="flight-number"><b>{{$order->inbound_flight_no}}</b></div>
                                    <div class="flight-airline">{{$order->inbound_airline}}</div>
                                </td>
                                <td width="50%"><b> Inbound</b></td>
                            </tr>
                            <tr>
                                <td class="flight-info">
                                    <div class="flight-date">{{$order->in_depart_date}}</div>
                                    <span class="flight-time">{{$order->in_depart_time}}</span>
                                    <span class="flight-airport"><b>{{$order->in_depart_airport}}</b></span>
                                </td>
                                <td class="flight-info">
                                    <div class="flight-date">{{$order->in_arrival_date}}</div>
                                    <span class="flight-time">{{$order->in_arrival_time}}</span>
                                    <span class="flight-airport"><b>{{$order->in_arrival_airport}}</b></span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="padding-top: 10px; font-weight: 300; line-height: 36px; font-size: 14px; font-family: 'Open Sans',Helvetica,Arial,sans-serif; color: #555; letter-spacing: -1px;">


                        <style>
                            #booking tr {
                                border: 1px solid #ccc;
                            }

                        </style>


                    </td>
                </tr>

                <tr>
                    <td>
                        <p>Thank you for patronizing us</p>
                        <br>

                        <p><b>Travellab Support Team</b></p>
                    </td>
                </tr>


            </table>
        </td>
    </tr>

    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="border:none; width:600; margin-top: 20px; margin-bottom: 40px; text-align: center; color: #85868a;">
                <tr>
                    <td style="padding-top: 20px;">
                        Copyright &copy; {{date('Y')}} TravelLab Limited. All Rights Reserved.
                    </td>
                </tr>

                {{--<tr>--}}
                {{--<td style="padding-top: 10px; font-weight: 800; font-size: 12px; text-transform: uppercase; font-family: 'Open Sans',Helvetica,Arial,sans-serif;">--}}
                {{--<a href="javascript: void(0);" target="_blank" style="color: #222; text-decoration: none;">Help Center</a> <span style="color: #222; font-size: 24px; margin-left: 20px; margin-right: 20px;">&#8901;</span>--}}
                {{--<a href="javascript: void(0);" target="_blank" style="color: #222; text-decoration: none;">1(800)234-56-78</a> <span style="color: #222; font-size: 24px; margin-left: 20px; margin-right: 20px;">&#8901;</span>--}}
                {{--<a href="javascript: void(0);" target="_blank" style="color: #222; text-decoration: none;">Unsubscribe</a>--}}
                {{--</td>--}}
                {{--</tr>--}}
            </table>
        </td>
    </tr>
</table>

</body>
</html>
