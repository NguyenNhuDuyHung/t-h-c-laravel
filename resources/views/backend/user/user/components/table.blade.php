<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>
                <input type="checkbox" value="" id="checkAll" class="input-checkbox">
            </th>
            <th>Họ Tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Nhóm</th>
            <th class="text-center">Tình trạng</th>
            <th class="text-center">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($users) && is_object($users))
            @foreach ($users as $user)
                <tr>
                    <td>
                        <input type="checkbox" value="{{ $user->id }}" class="input-checkbox checkBoxItem">
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                    <td>
                        {{ $user->email }}
                    </td>
                    <td>
                        {{ $user->phone }}
                    </td>
                    <td>
                        {{ $user->address }}
                    </td>
                    <td>
                        {{ $user->user_catalogues->name }}
                    </td>
                    <td class="text-center js-switch-{{ $user->id }}">
                        <input type="checkbox" value="{{ $user->publish }}" class="js-switch status"
                            data-field="publish" data-model="User" data-modelId="{{ $user->id }}"
                            {{ $user->publish == 2 ? 'checked' : '' }} />
                    </td>
                    <td class="text-center" style="display: flex; justify-content: center; gap: 5px;">
                        <a href="{{ route('user.edit', $user->id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i></a>
                        <form action="{{ route('user.delete', $user->id) }}" method="get">
                            <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

{{ $users->links('pagination::bootstrap-4') }}
