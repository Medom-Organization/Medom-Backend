<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"
      style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
<head>
    <meta name="viewport" content="width=device-width"/>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>TravelLab - Password - Reset</title>
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
                    <td style="padding-top: 10px; font-weight: 300; line-height: 36px; font-size: 18px; font-family: 'Open Sans',Helvetica,Arial,sans-serif; color: #666; letter-spacing: -1px; text-align:center;">
                        <p class="default-color"><b>Dear {{$user->fullname()}},</b></p>
                            <p>A Request to Reset Paasword Was Sent to us</p>
                            <p>Please click on the link below..</p>
                            <a href="https://www.travellab.ng/reset-password/{{$token}}" id="reset-btn">Reset Password</a>

                        {{--  </p>  --}}
                    </td>
                </tr>


                <style>
                    #reset-btn{
                        background-color:red;
                        color:white;
                        padding:0.6em 3.5em;
                        border-radius:4px;
                        /* margin */
                        text-decoration:none;
                        text-transform:uppercase;
                        margin:auto auto;
                        text-align:center;
                        align-self:center;
                        justify-content:center;
                        width:100%;
                    }
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
                    <td style="padding-top: 10px; font-weight: 300; line-height: 36px; font-size: 14px; font-family: 'Open Sans',Helvetica,Arial,sans-serif; color: #555; letter-spacing: -1px; text-align:center;">


                        <style>
                            #booking tr {
                                border: 1px solid #ccc;
                            }

                        </style>


                    </td>
                </tr>

                <tr>
                    <td style="text-align:center;">
                        <p>If You did not request this, no further action is required</p>
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
