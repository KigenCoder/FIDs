<table border="1">
    <tr>
        @for($i=0; $i<count($columnHeaders); $i++)
            <td><strong>{{$columnHeaders[$i]}}</strong></td>
        @endfor
    </tr>

    @for($i=0; $i<count($rowItems); $i++)
        @foreach($rowItems[$i] as $rowItem)
            <tr>
                <td>{{$rowItem->region}}</td>
                <td>{{$rowItem->district}}</td>
                <td>{{$rowItem->market}}</td>
                <td>{{$rowItem->marketType}}</td>
                <td>{{$rowItem->year}}</td>
                <td>{{$rowItem->month}}</td>
                @foreach($rowItem->rowCellItems as $rowCellItem)
                    <td>{{$rowCellItem->price> 0 ? number_format(round($rowCellItem->price)): ""}}</td>
                @endforeach
            </tr>
        @endforeach
    @endfor
</table>