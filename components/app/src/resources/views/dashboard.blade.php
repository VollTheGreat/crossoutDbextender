<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Crossout Bargers Dashboard</title>
    <link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
    {{--<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet"--}}
          {{--type="text/css">--}}
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <style>
        table td, table tr, table th{
            background: transparent !important;
            border: transparent !important;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <header>
        <a href="/?Rares" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">JS View Rares</a>
        <a href="/" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">JS View Epics</a>
        <a href="/dashboard/rares" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">Dashboard Rares</a>
        <a href="/dashboard/epics" style="margin-left:20px;color: hsla(43, 29%, 71%, 1)">Dashboard Epics</a>
    </header>

    <main style="margin-top: 30px">
        <div class="row col-md-8">
            <table id="myTable" style="width:100%;background-color:transparent">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Profit</th>
                </tr>
                </thead>
                <tbody>
                @foreach($data['crafts'] as $itemName=>$priceProfit)
                    <tr>
                        <th scope="row">{{$itemName}}</th>
                        <th >{{$priceProfit}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable({
            "order": [[1, "desc"]],
            "pageLength": 100
        });
    });
</script>
</body>
</html>
