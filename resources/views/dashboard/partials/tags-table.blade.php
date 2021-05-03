<table class="w-full table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Regex</th>
            <th>Hex Code</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>
                    <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/tags/{{ $tag->id }}">{{ $tag->name }}</a>
                </td>
                <td>{{ $tag->regex }}</td>
                <td>
                    <span class="rounded px-10px py-5px" style="background-color:#{{ $tag->hex_code }};">{{ $tag->hex_code }}</span>
                </td>
                <td>
                    <a class="link pri" href="/dashboard/accounts/{{ $account->id }}/tags/{{ $tag->id }}/delete">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
