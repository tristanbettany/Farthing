<table class="w-full table">
    <thead>
        <tr>
            <th>Date</th>
            <th>Tags</th>
            <th>Name</th>
            <th>Amount</th>
            <th>Running Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date->format('d-m-y H:i:s') }}</td>
                <td>
                    @foreach($transaction->tags as $tag)
                        <span class="rounded px-10px py-5px text-14px" style="background-color:{{ $tag->hex_code }};">{{ $tag->id }}</span>
                    @endforeach
                </td>
                <td><abbr title="{{ $transaction->name }}">{{ $transaction->getTruncatedName() }}</abbr></td>
                <td>{{ $transaction->amount }}</td>
                <td>{{ $transaction->running_total }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
