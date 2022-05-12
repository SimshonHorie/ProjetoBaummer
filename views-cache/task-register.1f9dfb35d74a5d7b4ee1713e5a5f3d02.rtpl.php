<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $error != ''  ){ ?>
        <div class="div-statusbar status-error">
            <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
        </div>
<?php } ?>
<header class="header">
    <h1 class="title">Cadastrar nova tarefa</h1>
</header>
<main class="main">
    <section class="section">
        <form action="/novatarefa" class="form" method="POST">
            <label for="responsavel" class="label-form">Colaborador</label>
            <select name="responsavel" id="responsavel" class="input-form">
                <?php $counter1=-1;  if( isset($employeeslist) && ( is_array($employeeslist) || $employeeslist instanceof Traversable ) && sizeof($employeeslist) ) foreach( $employeeslist as $key1 => $value1 ){ $counter1++; ?>
                <option value="<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></option>
                <?php } ?>
            </select>
            <label for="descricao" class="label-form">Descrição</label>
            <textarea type="text" name="descricao" class="input-form" placeholder="Insira a descrição da tarefa" rows="5" ></textarea>
            <label for="prioridade" class="label-form">Prioridade</label>
            <select name="prioridade" id="prioridade" class="input-form">
                <option value="baixa">Baixa</option>
                <option value="media">Média</option>
                <option value="alta">Alta</option>
            </select>
            <label for="prazolimite" class="label-form">Data/Hora Prazo Limite</label>
            <input type="datetime-local" class="input-form" name="prazolimite">
            <label for="dataexecucao" class="label-form">Data/Hora de Execução de tarefa</label>
            <input type="datetime-local" class="input-form" name="dataexecucao">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-green"><i class="fa-solid fa-plus"></i> Cadastrar
                    Tarefa</button>
            </div>
        </form>
    </section>
</main>