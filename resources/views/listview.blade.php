<?php
//status 0 × 1 〇
$lists = [['studentID' => '0001 ', 'name' => '田中太郎', 'class' => 'SK2A', 'place' => '社内', 'status' => '1', 'message' => 'This is a message', 'contact' => '0000000'], ['studentID' => '0002 ', 'name' => '山田次郎', 'class' => 'SK2A', 'place' => '社内', 'status' => '0', 'message' => 'This is a message2', 'contact' => '11111111'], ['studentID' => '0003 ', 'name' => '森花子', 'class' => 'IE2A', 'place' => '社内', 'status' => '1', 'message' => 'This is a message3', 'contact' => '22222222'], ['studentID' => '0004 ', 'name' => '鈴木隼人', 'class' => 'IE2A', 'place' => '社内', 'status' => '0', 'message' => 'This is a message', 'contact' => '4444444']];
//クラスの重複
$classes = array_unique(array_column($lists, 'class'));
//ok &#9989;;
//ng &#10060;

$user = Auth::user();
$id = Auth::id();
print_r($id);
?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Listview</title>
    @vite('resources/css/app.css')
</head>

<body>

    <div class="flex flex-col  items-center  h-screen">
        <h1 class="text-4xl m-5">Listview</h1>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>

        {{-- search bar --}}
        <div class="my-5">
            {{-- <form class="form"> --}}
            <input id="searchWord" type="text" class="seachWord" placeholder="search id or name..." />
            <button id=""
                class="clear-results bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-4 rounded"
                onclick="search()">
                SEARCH
            </button>
            <button id=""
                class="clear-results bg-blue-500 hover:bg-blue-700  text-white font-bold py-2 px-4 rounded"
                onclick="reload()">
                RELOAD
            </button>
            <select name="" id="class">
                <option value="">class</option>
                @foreach ($classes as $class)
                    <option value="{{ $class }}">
                        {{ $class }}
                    </option>
                @endforeach

            </select>
            {{-- </form> --}}
        </div>

        <table class="w-3/4 table-auto border-2 border-gray-600 " id="table">
            <thead class="border-2 border-gray-600 bg-gray-300 ">
                <tr id="th">
                    <th class="text-xl">ID </th>
                    <th class="text-xl">クラス </th>
                    <th class="text-xl">名前 </th>
                    <th class="text-xl">場所</th>
                    <th class="text-xl">メッセージ</th>
                    <th class="text-xl">連絡先</th>
                    <th class="text-xl">安全</th>
                </tr>
            </thead>

            @foreach ($lists as $l)
                <tr>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600">{{ $l['studentID'] }}</td>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600">{{ $l['class'] }}</td>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600">{{ $l['name'] }}</td>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600 ">{{ $l['place'] }}</td>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600">{{ $l['message'] }}</td>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600">{{ $l['contact'] }}</td>
                    <td class="text-center text-lg font-semibold border-b-2 border-gray-600">
                        @if ($l['status'] == 1)
                        &#9989;@else&#10062;
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>


</body>
<script>
    const table = document.getElementById("table");
    let searchRow = null;

    function search() {
        const searchWord = document.getElementById("searchWord");
        if (!searchWord) return;
        for (let row of table.rows) {
            if (row.cells[0].innerText == searchWord.value || row.cells[2].innerText == searchWord.value) {
                searchRow = row;
                console.log(searchRow);
            }
        }
        if (!searchRow) {
            searchWord.placeholder = "ID or NAME";
            searchWord.value = "";
            return;
        }

        deleteTable();

        table.appendChild(searchRow);

    }

    function deleteTable() {
        while (table.rows.length > 1) {
            table.deleteRow(1);
        }
    }

    function reload() {
        location.reload();
    }

    document.getElementById('class').addEventListener('change', (event) => {
        const searchClass = event.target.value;
        let lists = [];
        for (let row of table.rows) {
            if (row.cells[1].innerText == searchClass) {
                lists.push(row);
            }
        }
        deleteTable();
        lists.forEach(element => {
            table.appendChild(element);

        });
        console.log(lists);
    });
</script>

</html>
