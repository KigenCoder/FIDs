<table border="1">
    <th>Region</th>
    <th>District</th>
    <th>Market</th>
    <th>Year</th>
    <th>Month</th>
    @for($i=0; $i<count($rowItems); $i++)
        @foreach($rowItems[$i] as $rowItem)
            @foreach($rowItem->rowCellItems as $rowCellItem)
                <th>{{$rowCellItem->indicator_business_name}}</th>
            @endforeach
        @endforeach
    @endfor

    @for($i=0; $i<count($rowItems); $i++)
        @foreach($rowItems[$i] as $rowItem)
            <tr>
                <td>{{$rowItem->region}}</td>
                <td>{{$rowItem->district}}</td>
                <td>{{$rowItem->market}}</td>
                <td>{{$rowItem->year}}</td>
                <td>{{$rowItem->month}}</td>
                @foreach($rowItem->rowCellItems as $rowCellItem)
                    <td>{{number_format(round($rowCellItem->price))}}</td>
                @endforeach
            </tr>
        @endforeach
    @endfor
</table>