<table class="w-full table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Amount</th>
            <th>Date</th>
            <th>Running Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->name }}</td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->date->format('d-m-y H:i:s') }}</td>
                <td>{{ $transaction->running_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
