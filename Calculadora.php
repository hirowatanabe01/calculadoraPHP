<?php
session_start(); 

if (!isset($_SESSION['historico'])) {
    $_SESSION['historico'] = [];
}

// Faz o calculo
function calcular($numero1, $operador, $numero2) {
    switch ($operador) {
        case '+':
            return $numero1 + $numero2;
        case '-':
            return $numero1 - $numero2;
        case 'x':
            return $numero1 * $numero2;
        case '/':
            if ($numero2 != 0) {
                return $numero1 / $numero2;
            } else {
                return "Erro: Divisao por zero!";
            }
        case 'n!':
            return fatoracao($numero1);
        case 'x^y':
            return pow($numero1, $numero2);
        default:
            return "Operador invalido";
    }
}

// calcular fatorial
function fatoracao($num) {
    if ($num < 0) {
        return "Nao e possivel fazer fatoracao de numero negativo!";
    }
    $res = 1;
    for ($i = 2; $i <= $num; $i++) {
        $res *= $i;
    }
    return $res;
}

// botao salvar
if (isset($_POST['salvar'])) {
    $_SESSION['numero1'] = $_POST['numero1'];
    $_SESSION['numero2'] = $_POST['numero2'];
    $_SESSION['operador'] = $_POST['operador'];
}

// botao pegar valores
if (isset($_POST['pegar_valores'])) {
    $numero1 = $_SESSION['numero1'] ?? '';
    $numero2 = $_SESSION['numero2'] ?? '';
    $operador = $_SESSION['operador'] ?? '';
}
// botao Calcular
if (isset($_POST['calcular'])) {
    $resultado = calcular($_POST['numero1'], $_POST['operador'], $_POST['numero2']);
    $operacao = $_POST['numero1'] . ' ' . $_POST['operador'] . ' ' . $_POST['numero2'] . ' = ' . $resultado;
    
    $_SESSION['historico'][] = $operacao;
}

// botao apagar historico 
if (isset($_POST['apagar_historico'])) {
    $_SESSION['historico'] = [];
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <title>Calculadora PHP</title>
</head>
<body>
    <h1>Calculadora PHP</h1>

    <form action="calculadora.php" method="post">
        <input type="text" name="numero1" placeholder="Digite o primeiro numero" value="<?php echo $numero1 ?? ''; ?>">
        <br><br>
        <select name="operador">
            <option value="+" <?php echo (isset($operador) && $operador == '+') ? 'selected' : ''; ?>>+</option>
            <option value="-" <?php echo (isset($operador) && $operador == '-') ? 'selected' : ''; ?>>-</option>
            <option value="x" <?php echo (isset($operador) && $operador == 'x') ? 'selected' : ''; ?>>x</option> 
            <option value="/" <?php echo (isset($operador) && $operador == '/') ? 'selected' : ''; ?>>/</option>
            <option value="n!" <?php echo (isset($operador) && $operador == 'n!') ? 'selected' : ''; ?>>n!</option>
            <option value="x^y" <?php echo (isset($operador) && $operador == 'x^y') ? 'selected' : ''; ?>>x^y</option> 
        </select>
        <br><br>
        <input type="text" name="numero2" placeholder="Digite o segundo numero" value="<?php echo $numero2 ?? ''; ?>">
        <br><br>
        <input type="submit" name="calcular" value="Calcular">
        <br><br>
        <input type="text" name="resultado" placeholder="Resultado" value="<?php echo $resultado ?? ''; ?>" readonly>
        <br><br>
        <input type="submit" name="salvar" value="Salvar Valores">
        <input type="submit" name="pegar_valores" value="Carregar Valores">
        <input type="submit" name="apagar_historico" value="Apagar Historico">
    </form>

    
    <h3>Historico</h3>
    <ul>
        <?php foreach ($_SESSION['historico'] as $operacao): ?>
            <li><?php echo $operacao; ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>