<!DOCTYPE html>
<html>
<head>
    <title>領収書</title>
    <meta charset="UTF-8">
    <script>
    window.print();
    </script>
    <link href="{{ asset('css/invoice.css') }}" rel="stylesheet" type="text/css">
    <style>
        h1 {
            display: inline-block;
        }

        h2 { font-size: 2em; }

        .invoice-details {
            float: right;
        }

        .invoice-details span { font-weight: normal; font-size: .9em;}

        .total { float: right; }
        .total .amount { font-weight: normal; }

        table { margin-top: 50px; }
        thead { background: #bb574e; color: white; }
        thead th { border: none !important; }

        .notice {
            background: #e9e9e9;
            padding: 2em;
            clear: both;
            margin-top: 6em;
        }

        .col {
            float: left;
            width: 300px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>領収書</h1>

            <div class="invoice-details">
                <h2 contenteditable="">ID: {{ $invoice_data[0]->invoice_id }}</h2>
                <h4 contenteditable="">発行日: <span id="date-of-invoice">{{ date('Y/n/d', strtotime($invoice_data[0]->updated_at)) }}</span></h4>
            </div>
        </div>

        <div class="row billing__references">
            <div class="col">
                <h4>To:</h4>
                <h5 contenteditable="">{{ $user_data->username }}</h5>

                <p contenteditable="">
                {{ $user_data->email }}
                </p>
            </div>

            <div class="col">
                <h4>From:</h4>
                <h5>大阪コード学園</h5>

                <p class="address" contenteditable="">
                    (名前)<br/>
                    (住所)<br/>
                    osakacode@gakuen.com<br/>
                    (電話番号)<br/>
                </p>
            </div>
        </div>

        <div class="row billing__lines">
            <table class="lines table table-striped">
                <thead>
                    <tr>
                        <th>数量</th>
                        <th>サービス内容</th>
                        <th>料金</th>
                    </tr>
                </thead>

                <tbody>
                    <tr contenteditable="">
                        <td>{{ $invoice_data[0]->quantity }}</td>
                        <td>プログラミング学習サービス 月額利用料金</td>
                        <td>{{ $invoice_data[0]->quantity * $data['plan_data']->price }}円</td>
                    </tr>
                </tbody>
            </table>

            <div class="total">
                <h4>合計: <span class="amount">{{ $invoice_data[0]->quantity * $data['plan_data']->price }}円</span></h4>
            </div>
        </div>
    </div>
</body>
</html>
