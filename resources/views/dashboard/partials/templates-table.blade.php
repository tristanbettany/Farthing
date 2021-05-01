<table class="w-full table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Amount</th>
            <th>Occurances</th>
            <th>Occurance Syntax</th>
            <th>Active?</th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach($templates as $template)
            <tr>
                <td>{{ $template->name }}</td>
                <td>{{ $template->amount }}</td>
                <td>{{ $template->occurances }}</td>
                <td>{{ $template->occurance_syntax }}</td>
                <td>
                    @if($template->is_active === true)
                        <span class="rounded bg-pri-500 px-10px py-5px text-white">Yes</span>
                    @else
                        <span class="rounded bg-ter-100 px-10px py-5px">No</span>
                    @endif
                </td>
                <td>
                    <a class="link pri" href="/dashboard/templates/{{ $template->id }}/edit">Edit</a> |
                    <a class="link pri" href="/dashboard/templates/{{ $template->id }}/deactivate">Deactivate</a> |
                    <a class="link pri" href="/dashboard/templates/{{ $template->id }}/delete">Delete</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
