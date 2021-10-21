<html>
    <head>
    <style>
* {
  box-sizing: border-box;
}

/* Create two equal columns that floats next to each other */
.column {
  float: left;
  width: 50%;
  padding: 10px;
  text-align:center;
  border-color: black;
    border-width: 1px;
    border-style: solid;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}
@media print{
    tr{
        page-break-inside:avoid;
    }
}
</style>
    </head>
    <body>
        <table width="100%" border="1" style="border-collapse: collapse;text-align:center;">
        <tr>
        @php
        $i=0;
        @endphp
            @foreach($batch->members as $member)
            @if(($i++)%2==0)
                </tr><tr>
            @endif
            <td width="50%">
            <h4>{{ $member->full_name }}</h4>
            <p>{{ $member->address_detail }}</p>
            <p>{{ $member->phone }}</p>
            </td>
            @endforeach
        </tr>
        </table>
        <script>
        window.print();
        </script>
    </body>
</html>