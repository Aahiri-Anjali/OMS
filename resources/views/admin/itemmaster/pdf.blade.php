<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>User List</title>
    <style>
        table {
            /* border-collapse: collapse; */
            /* width: 100%; */
            /* padding-left: "100px"; */
        }

        th,
        td {
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <center>
        <img src="\nanomine.png" alt="Logo"
            height="100" width="90">
            <h1>Nanomine Technolabs Pvt. Lmt.</h1>
            <p>Royal Square, 212, ROB Bridge, nr. Utran, Uttran, Surat, Gujarat 394105</p>
            <u><h2>Order Management System</h2></u>
    </center>
    <center>
        <table>
            <thead>
                <tr>
                    <th>Brand Name</th>
                    <th>SubBrand Name</th>
                    <th>Category Name</th>
                    <th>SubCategory Name</th>
                    <th>Item Name</th>
                    <th>Item Code</th>
                    <th>Price</th>
                    <th>Barcode</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->brand->name }}</td>
                        <td>{{ $item->subbrand->name }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>{{ $item->subcategory->name }}</td>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->item_code }}</td>
                        <td>{{ $item->sellprice }}</td>
                        @php
                            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
                        @endphp
                        <td><img
                                src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($item->sellprice, $generatorPNG::TYPE_CODE_128)) }}" width="100px" />
                        </td>
                    </tr>
                @endforeach
        </table>
    </center>
</body>
</tbody>
</table>
</body>

</html>
