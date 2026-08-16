<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        @page {
            margin: 40px 50px;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            overflow: hidden;
            margin-bottom: 30px;
        }

        .header .business-name {
            font-size: 22px;
            font-weight: bold;
            float: left;
        }

        .header .invoice-title {
            float: right;
            text-align: right;
        }

        .header .invoice-title h1 {
            font-size: 22px;
            margin: 0;
        }

        .header .invoice-title span {
            color: #777;
        }

        .clear {
            clear: both;
        }

        .info-row {
            overflow: hidden;
            margin-bottom: 20px;
        }

        .bill-to {
            float: left;
            width: 50%;
        }



        .dates {
            float: right;
            text-align: right;
            width: 45%;
        }

        .dates table {
            width: 100%;
            border-collapse: collapse;
        }

        .dates td {
            padding: 2px 0;
        }

        .dates td:first-child {
            color: #555;
            padding-right: 20px;
        }

        .dates td:last-child {
            font-weight: bold;
            text-align: right;
        }

        .summary-bar {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        .summary-bar td {
            padding: 12px 15px;
            color: #fff;
        }

        .summary-bar .cell-label {
            display: block;
            font-size: 10px;
            opacity: 0.85;
        }

        .summary-bar .cell-value {
            font-size: 15px;
            font-weight: bold;
        }

        .summary-bar .orange {
            background-color: #f5a623;
        }

        .summary-bar .dark {
            background-color: #2b2b2b;
        }

        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table.items th {
            text-align: left;
            border-bottom: 2px solid #333;
            padding: 6px 4px;
            font-size: 12px;
        }

        table.items th.num,
        table.items td.num {
            text-align: right;
        }

        table.items td {
            padding: 8px 4px;
            border-bottom: 1px solid #ddd;
        }

        table.totals {
            width: 100%;
            margin-bottom: 40px;
        }

        table.totals td {
            padding: 4px 0;
        }

        table.totals td.label {
            text-align: left;
        }

        table.totals td.value {
            text-align: right;
        }

        table.totals tr.total td {
            font-weight: bold;
            font-size: 14px;
            border-top: 1px solid #333;
            padding-top: 8px;
        }

        .signature-block {
            text-align: right;
            margin-top: 40px;
        }

        .signature-block .sig-label {
            font-weight: bold;
            margin-bottom: 30px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 50px;
            right: 50px;
            font-size: 10px;
            color: #555;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }

        .footer .contact {
            overflow: hidden;
            margin-bottom: 4px;
        }

        .footer .contact span {
            display: inline-block;
        }

        .bill-to strong {
            display: block;
            margin-bottom: 4px;
            color: #333;
        }

        .header {
            overflow: hidden;
            margin-bottom: 30px;
            color: #333;
        }

        .business-name {
            font-size: 22px;
            font-weight: bold;
            float: left;
            color: #333;
        }

        .info-row {
            overflow: hidden;
            margin-bottom: 20px;
            color: #333;
        }

        .bill-to {
            float: left;
            width: 50%;
            color: #333;
        }

        .bill-to * {
            color: #333;
        }
    </style>
</head>

<body>

    <div class="header">
        <div class="business-name">{{ $invoice['business']['name'] }}</div>
        <div class="invoice-title">
            <h1>Invoice {{ $invoice['number'] }}</h1>
            <span>Tax invoice</span>
        </div>
         <div class="signature-block">
        <div class="sig-label">Issued by, signature:</div>
        <img src="{{ public_path('images/kadamba.jpg') }}" height="60">
    </div>
    </div>
    <div class="clear"></div>

    <div class="info-row">
        <div class="bill-to">
            <strong>BILL TO</strong>
            <span>{{ $invoice['client']['name'] }}</span><br>
            <span>{!! nl2br(e($invoice['client']['address'])) !!}</span>
        </div>
        <div class="dates">
            <table>
                <tr>
                    <td>Issue date:</td>
                    <td>{{ $invoice['issue_date'] }}</td>
                </tr>
                <tr>
                    <td>Due date:</td>
                    <td>{{ $invoice['due_date'] }}</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Reference:</td>
                    <td>{{ $invoice['reference'] }}</td>
                </tr>
            </table>
        </div>
    </div>
    <div class="clear"> </div>

    <table class="summary-bar">
        <tr>
            <td class="orange" style="width: 25%;">
                <span class="cell-label">Invoice No.</span>
                <span class="cell-value">{{ $invoice['number'] }}</span>
            </td>
            <td class="orange" style="width: 25%;">
                <span class="cell-label">Issue date</span>
                <span class="cell-value">{{ $invoice['issue_date'] }}</span>
            </td>
            <td class="orange" style="width: 25%;">
                <span class="cell-label">Due date</span>
                <span class="cell-value">{{ $invoice['due_date'] }}</span>
            </td>
            <td class="dark" style="width: 25%;">
                <span class="cell-label">Total due (AUD)</span>
                <span class="cell-value">${{ number_format($invoice['total'], 2) }}</span>
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th class="num">Quantity</th>
                <th class="num">Unit price ($)</th>
                <th class="num">Amount ($)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice['items'] as $item)
            <tr>
                <td>{{ $item['description'] }}</td>
                <td class="num">{{ $item['qty'] }}</td>
                <td class="num">{{ number_format($item['unit_price'], 2) }}</td>
                <td class="num">{{ number_format($item['amount'], 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label" style="width: 80%;">Subtotal:</td>
            <td class="value">${{ number_format($invoice['subtotal'], 2) }}</td>
        </tr>
        @foreach ($invoice['gst_lines'] as $gst)
        <tr>
            <td class="label"><i>{{ $gst['label'] }}</i></td>
            <td class="value">${{ number_format($gst['amount'], 2) }}</td>
        </tr>
        @endforeach
        <tr class="total">
            <td class="label">Total (AUD):</td>
            <td class="value">${{ number_format($invoice['total'], 2) }}</td>
        </tr>
    </table>

    <!-- <div class="signature-block">
        <div class="sig-label">Issued by, signature:</div>
        <img src="{{ public_path('images/kadamba.jpg') }}" height="60">
    </div> -->

    <div class="footer">
        <div class="contact">
            <span>{{ $invoice['business']['phone'] }}</span>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span>{{ $invoice['business']['website'] }}</span>
            &nbsp;&nbsp;&nbsp;&nbsp;
            <span>{{ $invoice['business']['email'] }}</span>
        </div>
        <div>
            {{ $invoice['business']['name'] }} — {{ str_replace("\n", ', ', $invoice['business']['address']) }}
        </div>
    </div>

</body>

</html>