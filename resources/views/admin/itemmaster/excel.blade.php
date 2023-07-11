<center>
    <h1>Nanomine Technolabs Pvt. Lmt.</h1>
    <h4>Royal Square, 212, ROB Bridge, nr. Utran, Uttran, Surat, Gujarat 394105</h4>
    <u>
        <h2>Order Management System</h2>
    </u>
</center>
<br>

<table>
    <thead>
        <tr>
            <th><b>Brand Name</b></th>
            <th><b>SubBrand Name</b></th>
            <th><b>Category Name</b></th>
            <th><b>SubCategory Name</b></th>
            <th><b>Item Name</b></th>
            <th><b>Item Code</b></th>
            <th><b>Price</b></th>
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

            </tr>
        @endforeach
</table>
