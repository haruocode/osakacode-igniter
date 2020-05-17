@extends ('front.template')
@section ('main')

    <div class="container">
        <section class="Setting utility-flex-container">
            @include('settings.includes.sidebar')
            <div class="Setting Box Box--Large Box--bright utility-flex">
                <h2 class="Setting__heading">
                    お支払履歴
                </h2>
                <section>
                    <table class="Table Table--Bordered">
                        <thead class="accent">
                        <tr>
                            <th>決済日</th>
                            <th>料金</th>
                            <th>ステータス</th>
                            <th>領収書</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php foreach ($data['invoices'] as $invoices) { ?>
                        <tr>
                            <td>{{ date('Y/n/d', strtotime($invoices->updated_at)) }}</td>
                            <td><?php
                                $this->load->model('invoice_model');
                                $plan = $this->invoice_model->get_plan_from_invoice($invoices->plan_id);
                                echo($plan[0]->price * $invoices->quantity);
                                ?>円
                            </td>
                            <td><?php if ($invoices->status == 0) echo 'お手続き中'; else echo 'お支払済み'; ?> </td>
                            <td><a href="/settings/subscription/invoices/{{ $invoices->invoice_id }}" target="_blank">詳細</a></td>
                        </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </section>
            </div>
        </section>
    </div>
@stop
