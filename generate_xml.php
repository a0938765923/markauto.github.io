<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 獲取表單數據
    $products = [];
    $Sku = $_POST['Sku'];
    $Name = $_POST['Name'];
    $Description = $_POST['Description'];
    $URL = $_POST['URL'];
    $Price = $_POST['Price'];
    $Largeimage = $_POST['Largeimage'];
    $SalePrice = $_POST['SalePrice'];
    $Category = $_POST['Category'];

    // 使用 Sku 數組的長度作為迴圈條件
    for ($i = 0; $i < count($Sku); $i++) {
        $products[] = [
            'Sku' => htmlspecialchars($Sku[$i]),
            'Name' => htmlspecialchars($Name[$i]),
            'Description' => htmlspecialchars($Description[$i]),
            'URL' => htmlspecialchars($URL[$i]),
            'Price' => htmlspecialchars($Price[$i]),
            'Largeimage' => htmlspecialchars($Largeimage[$i]),
            'SalePrice' => htmlspecialchars($SalePrice[$i]),
            'Category' => htmlspecialchars($Category[$i]),
        ];
    }

    // 生成 XML
    function array_to_xml($data, &$xml_data) {
        foreach ($data as $product) {
            $subnode = $xml_data->addChild('product');
            foreach ($product as $key => $value) {
                $subnode->addChild($key, htmlspecialchars($value));
            }
        }
    }

    function generate_xml($products) {
        $xml_data = new SimpleXMLElement('<?xml version="1.0"?><products></products>');
        array_to_xml($products, $xml_data);
        return $xml_data->asXML();
    }

    // 生成 XML 並儲存為檔案
    $xml_output = generate_xml($products);
    file_put_contents('products.xml', $xml_output);

    echo "XML 檔案已生成！<br>";
    echo '<a href="products.xml">點擊這裡下載 XML 檔案</a>';
}
?>
