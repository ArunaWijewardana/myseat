<?

//get capabilities
$cap = querySQL('capabilities');

echo "<br/><h4>"._users." "._type."</h4>";
echo "<table class='global'><tr>";
echo"<th></th>";
    foreach($roles as $key=>$values){
        echo"<th>".$values."</th>";
    }
echo "</tr>\n";
// printing table rows
    echo "<tr>";
    // $row is array... foreach( .. ) puts every element
    // of $row to $cell variable
while( $row = mysql_fetch_array($cap) ){
    foreach($row  as $key => $value){
        if($key!='0'){
            if($key=='capability'){
                echo "<td><strong>".str_replace('-',' ',$value)."</strong></td>";
            }else{
                echo "<td>".printOnOff($value)."</td>";
            }
        }
    }
    echo "</tr>\n";
}
?>
</table>
<br/>