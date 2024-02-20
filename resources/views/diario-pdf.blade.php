<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diário Oficial</title>
    <style>
        .div1 {
            width: 50%;
            float: left;
        }

        .div2 {
            width: 50%;
            float: left;
            padding-left: 10px;;
        }
    </style>
</head>

<body>
    <?php 
function textotam($texto,$tamanho) {
	if (strlen($texto) > $tamanho) {
			for ($i = $tamanho;$i <= strlen($texto); $i++) {
				if (substr($texto,$i,1) == " ") {
					return substr($texto,0,$i)."...";
				}
			}
			return $texto;
    }
    else {
        return $texto;
    }
}
$cont = (strlen($dados->content) / 2);
$arr = str_split($dados->content, $cont);
//dd($arr);
?>
    <div class="conteudo">
        <div style="text-align: center"><b>{{ $dados->title }}</b></div>
        <div style="margin-top: 5%" class="div1">{{ textotam($arr[0],$cont) }}</div>
        <div style="margin-top: 5%" class="div2">{{ textotam($arr[1],$cont) }}</div>
    </div>
</body>

</html>