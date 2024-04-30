@if ($subscriptionPayments)
<table class="table">
    <thead>
        <tr>
            <th>Data</th>
            <th>Valor</th>
            <th>Plano</th>
            <th>Método</th>
            <th>Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($subscriptionPayments as $subscriptionPayment)
        <tr>
            <td>{{ $subscriptionPayment->created_at }}</td>
            <td>€ {{ $subscriptionPayment->value }}</td>
            <td>{{ $subscriptionPayment->subscription->subscription_type->plan->name }}</td>
            <td>{{ $subscriptionPayment->method }}</td>
            <td>{!! $subscriptionPayment->paid == 1 ? '<span class="badge badge-success">Pago</span>' : '<span
                    class="badge badge-danger">Aguarda pagamento</span>' !!}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<div class="alert alert-primary" role="alert">
    Ainda não existem pagamentos.
</div>
@endif