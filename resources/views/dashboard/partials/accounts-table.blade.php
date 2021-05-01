<table class="w-full table">
    <thead>
        <tr>
            <th>Account Name</th>
            <th>Sort Code</th>
            <th>Account Number</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($accounts as $account)
            <tr>
                <td>{{ $account->name }}</td>
                <td>{{ $account->sort_code }}</td>
                <td>{{ $account->account_number }}</td>
                <td>
                    <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/transactions">View Transactions</a> |
                    <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/templates">View Templates</a> |
                    <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/tags">View Tags</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
