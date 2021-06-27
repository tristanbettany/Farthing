<table class="w-full table">
    <thead>
        <tr>
            <th>Date</th>
            <th></th>
            <th>Name</th>
            <th>Amount</th>
            <th>Running Total</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($transactions as $transaction)
            <tr>
                <td>{{ $transaction->date->format('d-m-Y') }}</td>
                <td>
                    @foreach($transaction->tags as $tag)
                        <a href="/dashboard/accounts/{{ $account->id }}/tags/{{ $tag->id }}" title="{{ $tag->name }}" class="rounded px-10px py-5px relative inline-block cursor-pointer {{ $tag->is_light_text === true ? 'text-white' : '' }}" style="background-color:#{{ $tag->hex_code }};">{{ $tag->name }}</a>
                    @endforeach
                </td>
                <td>
                    <abbr title="{{ $transaction->name }}">{{ $transaction->getTruncatedName() }}</abbr>
                </td>
                <td>
                    <span class="{{ session('redacted') === true ? 'rounded bg-black text-black px-10px py-5px' : '' }}">{{ $transaction->amount }}</span>
                </td>
                <td>
                    <span class="{{ session('redacted') === true ? 'rounded bg-black text-black px-10px py-5px' : '' }}">{{ $transaction->running_total }}</span>
                </td>
                <td>
                    @if($transaction->is_cashed === true)
                        <span class="rounded bg-ter-100 px-10px py-5px">Cashed</span>
                    @elseif($transaction->is_pending === true)
                        <span class="rounded bg-warning-300 px-10px py-5px">Pending</span>
                    @elseif($transaction->is_future === true)
                        <span class="rounded bg-pri-400 px-10px py-5px text-white">Future</span>
                    @endif
                </td>
                <td>
                    @if($transaction->is_cashed === false)
                        <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/transactions/{{ $transaction->id }}">Edit</a>
                        |
                        <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/transactions/{{ $transaction->id }}/delete">Delete</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
