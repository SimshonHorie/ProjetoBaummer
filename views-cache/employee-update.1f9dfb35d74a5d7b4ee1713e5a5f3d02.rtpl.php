<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $error != ''  ){ ?>
<div class="div-statusbar status-error">
    <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
    <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
</div>
<?php } ?>
<header class="header">
    <h1 class="title">Editar Colaborador <?php echo htmlspecialchars( $employee["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
</header>
<main class="main">
    <section class="section">
        <form action="/areacolaboradores/<?php echo htmlspecialchars( $employee["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/editarcolaborador" class="form" method="POST">
            <label for="nome" class="label-form">Nome</label>
            <input type="text" class="input-form" placeholder="Insira um nome" name="nome" value="<?php echo htmlspecialchars( $employee["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="cpf" class="label-form">CPF</label>
            <input type="text" class="input-form" id="cpf" placeholder="Insira um cpf válido" name="cpf"
                value="<?php echo htmlspecialchars( $employee["cpf"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="email" class="label-form">Email</label>
            <input type="text" class="input-form" placeholder="Insira um email" name="email" value="<?php echo htmlspecialchars( $employee["email"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-blue"><i class="fa-solid fa-pen-to-square"></i> Editar
                    Colaborador</button>
            </div>
        </form>
    </section>
</main>