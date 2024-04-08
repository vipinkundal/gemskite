<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Invoice #{{$order->id}}</title>

    <style>
        html,
        body {
            margin: 10px;
            padding: 10px;
            font-family: sans-serif;
        }
        h1,h2,h3,h4,h5,h6,p,span,label {
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0px !important;
        }
        table thead th {
            height: 28px;
            text-align: left;
            font-size: 16px;
            font-family: sans-serif;
        }
        table, th, td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }
        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }
        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }
        .order-details tbody tr td:nth-child(1) {
            width: 20%;
        }
        .order-details tbody tr td:nth-child(3) {
            width: 20%;
        }

        .text-start {
            text-align: left;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }
        .no-border {
            border: 1px solid #fff !important;
        }
        .bg-blue {
            background-color: #414ab1;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">

    <table class="order-details">
        <thead>
            <tr>
                <th width="100%" colspan="2">
                    <h2 class="text-start">Invantory Invoice</h2>
                    <span>Invoice Id : {{$order->id}}</span> <br>
                </th>
            </tr>
            <tr class="bg-blue">
                <th width="50%" colspan="2">Invoice Details</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Invoice Id:</td>
                <td>{{$order->id}}</td>

            </tr>
            <tr>
                <td>Name:</td>
                <td>{{$order->name}}</td>

            </tr>
            <tr>
                <td>Firm Name:</td>
                <td>{{$order->firm_name}}</td>

            </tr>
            <tr>
                <td>City:</td>
                <td>{{$order->city}}</td>

            </tr>
            <tr>
                <td>State:</td>
                <td>{{$order->state}}</td>

            </tr>
            <tr>
                <td>Phone:</td>
                <td>{{$order->phone}}</td>

            </tr>
            <tr>
                <td>Email:</td>
                <td>{{$order->email}}</td>

            </tr>
            <tr>
                <td>Address:</td>
                <td>{{$order->address}}</td>

            </tr>
            <tr>
                <td>Gst Details:</td>
                <td>{{$order->gst_details}}</td>

            </tr>
            <tr>
                <td>Created At:</td>
                <td>{{$order->updated_at->format('d-M-Y h:i A')}}</td>

            </tr>
        </tbody>
    </table>



    <br>
    <p class="text-center">
        Thank your for shopping with Gemskite.
    </p>

</div>
</body>
</html>
