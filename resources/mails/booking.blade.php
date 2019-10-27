<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>TravelLab - New Booking</title>
    {{--<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet">--}}
    <style>

        #page {
            width: 595px;
            min-height: 842px;
        }

        .default-color {
            color: #666;
        }

        .text-right {
            text-align: right;
            /*padding-right: 10px;*/
            /*font-weight: bold;*/
        }

        .text-primary {
            color: #AD3335;
        }

        .bg-primary {
            background: #AD3335;
            color: #fff;
        }

        .bg-primary-lite {
            background: #F48884;
        }

        .text-primary-lite {
            color: #F48884;
        }
    </style>
</head>
<body style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f8f8f8; margin: 0;">

<table border="0" cellpadding="0" cellspacing="0"
       style="width: 100%; background-color: #f4f8fb; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px;"
       bgcolor="#f8f8f8">

    <tr>
        <td>
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="595"
                   style="width:595px; min-height: 842px; background-color: #ffffff; color: #514d6a; padding: 20px; margin-top: 20px; line-height: 28px;"
                   bgcolor="#ffffff">
                <tr>
                    <td style="vertical-align: top;">
                        <table width="100%">
                            <tr>
                                <td>
                                    <img src="{{ 'data:image/png;base64, '.base64_encode(file_get_contents(public_path('/images/logo.png'))) }}" alt="Travellab Logo"
                                    style="border:none; display:inline-block;" height="60">
                                </td>
                                <td style="float: right">
                                    <div style="width: 130px; float: right">
                                        <div style="background: #AD3335; padding: 3px; text-align: center; color: #fff;">
                                            Booking Reference
                                        </div>
                                        <div style="border: 1px solid #AD3335; font-size: 1.2em; color:#AD3335; padding: 3px; text-align: center; font-weight: bold">
                                            {{$ticket->booking_ref}}
                                        </div>

                                    </div>


                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td>

                    </td>
                </tr>


                <tr>
                    <td style="padding-top: 10px; font-weight: 300; line-height: 20px; font-size: 14px; font-family: 'Open Sans',Helvetica,Arial,sans-serif; color: #666; letter-spacing: 0px;">

                        <p class="text-primary"
                           style="font-size: 1.1em; border-bottom: 0px solid #F48884; margin-bottom: 3px; padding-bottom: 5px;">
                            <b>Booking Information</b></p>
                        <table width="400px" style="font-size: 0.8em">
                            <tr>
                                <td width="30%">
                                    <b>Issue Date:</b>
                                </td>
                                <td>
                                    {{$ticket->issue_date}}
                                </td>
                            </tr>

                            <tr>
                                <td >
                                    <b>Status</b>
                                </td>
                                <td>
                                    {{$ticket->status}}
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <b> Travelers</b>
                                </td>
                                <td>
                                    @foreach($ticket->travellers  as $traveller)
                                        <p>{{$traveller}}</p>
                                    @endforeach

                                </td>
                            </tr>
                        </table>

                        <table width="100%">
                            <tr>
                                <td>
                                    <p class="text-primary" style="margin-bottom: 3px"><b>Your Itinerary</b></p>
                                    @foreach($ticket->outbound_itinerary as $segment)
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="60%" class="bg-primary" style="padding: 5px 10px; font-weight: bold; ">{{$ticket->outbound_from_to}}</td>
                                            <td class="bg-primary text-right" style="padding: 5px 10px;">Outbound
                                            </td>

                                        </tr>
                                        <tr>
                                            <td colspan="2">


                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td  style=" border-bottom: 2px double #F48884; ">
                                                                <p style="padding-bottom: 0px; margin-bottom: 0px;">{{$segment->date}}</p>
                                                            </td>
                                                            <td  class="text-right" colspan="2"  style="border-bottom: 2px double #F48884">
                                                                <p style="padding-bottom: 5px; margin-bottom: 0px; " class="text-primary">
                                                                    <b>{{$segment->from}}</b> to <b>{{$segment->to}}</b></p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" >
                                                                <p style="padding-bottom: 5px; margin-bottom: 0px; font-size: 1.3em; font-weight: bold;" class="text-primary-lite">{{$segment->airway}}</p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td><b>Depart:</b></td>
                                                            <td>{{$segment->departure_date}}</td>
                                                            <td><b>{{$segment->departure_airport}}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Arrive:</b></td>
                                                            <td>{{$segment->arrival_date}}</td>
                                                            <td><b>{{$segment->arrival_airport}}</b></td>
                                                        </tr>


                                                    </table>
                                                    <br>
                                                    <table width="100%" style="font-size: 0.9em">
                                                        <tr>
                                                            <td><b>Flying Time:</b></td>
                                                            <td>{{$segment->flying_time}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Booking Status:</b></td>
                                                            <td>{{$segment->status}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Aircraft:</b></td>
                                                            <td>{{$segment->aircraft}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Class:</b></td>
                                                            <td>Economy</td>
                                                        </tr>
                                                    </table>

                                            </td>
                                        </tr>
                                    </table>
                                    @endforeach




                                    @foreach($ticket->inbound_itinerary as $segment)
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="60%" class="bg-primary" style="padding: 5px 10px; font-weight: bold; ">{{$ticket->outbound_from_to}}</td>
                                                <td class="bg-primary text-right" style="padding: 5px 10px;">Inbound
                                                </td>

                                            </tr>
                                            <tr>
                                                <td colspan="2">


                                                    <table width="100%" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td  style=" border-bottom: 2px double #F48884; ">
                                                                <p style="padding-bottom: 0px; margin-bottom: 0px;">{{$segment->date}}</p>
                                                            </td>
                                                            <td  class="text-right" colspan="2"  style="border-bottom: 2px double #F48884">
                                                                <p style="padding-bottom: 5px; margin-bottom: 0px; " class="text-primary">
                                                                    <b>{{$segment->from}}</b> to <b>{{$segment->to}}</b></p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td colspan="2" >
                                                                <p style="padding-bottom: 5px; margin-bottom: 0px; font-size: 1.3em; font-weight: bold;" class="text-primary-lite">{{$segment->airway}}</p>
                                                            </td>

                                                        </tr>
                                                        <tr>
                                                            <td><b>Depart:</b></td>
                                                            <td>{{$segment->departure_date}}</td>
                                                            <td><b>{{$segment->departure_airport}}</b></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Arrive:</b></td>
                                                            <td>{{$segment->arrival_date}}</td>
                                                            <td><b>{{$segment->arrival_airport}}</b></td>
                                                        </tr>


                                                    </table>
                                                    <br>
                                                    <table width="100%" style="font-size: 0.9em">
                                                        <tr>
                                                            <td><b>Flying Time:</b></td>
                                                            <td>{{$segment->flying_time}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Booking Status:</b></td>
                                                            <td>{{$segment->status}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Aircraft:</b></td>
                                                            <td>{{$segment->aircraft}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Class:</b></td>
                                                            <td>Economy</td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                        </table>
                                    @endforeach




                                </td>
                            </tr>
                        </table>
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
