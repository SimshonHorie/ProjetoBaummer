<?php if(!class_exists('Rain\Tpl')){exit;}?><header class="header">
    <h1 class="title">Editar Dados da Tarefa #<?php echo htmlspecialchars( $task["idtarefa"], ENT_COMPAT, 'UTF-8', FALSE ); ?></h1>
</header>
<main class="main">
    <section class="section">
        <form action="/novatarefa" class="form" method="POST">
            <label for="responsavel" class="label-form">Colaborador</label>
            <input type="text" class="input-form" value="<?php echo htmlspecialchars( $task["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" readonly>
            <label for="descricao" class="label-form">Descrição</label>
            <textarea type="text" name="descricao" class="input-form" placeholder="Insira a descrição da tarefa" rows="5" ><?php echo htmlspecialchars( $task["descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea>
            <label for="prioridade" class="label-form">Prioridade</label>
            <select name="prioridade" id="prioridade" class="input-form">
                <option value="baixa" <?php if( $task["prioridade"] == 'baixa' ){ ?>selected<?php } ?>>Baixa</option>
                <option value="media" <?php if( $task["prioridade"] == 'media' ){ ?>selected<?php } ?>>Média</option>
                <option value="alta" <?php if( $task["prioridade"] == 'alta' ){ ?>selected<?php } ?>>Alta</option>
            </select>
            <label for="prazolimite" class="label-form">Data/Hora Prazo Limite</label>
            <input type="datetime-local" class="input-form" name="prazolimite" value="<?php echo htmlspecialchars( $task["prazolimite"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <label for="dataexecucao" class="label-form">Data/Hora de Execução de tarefa</label>
            <input type="datetime-local" class="input-form" name="dataexecucao" value="{function='formatDate($task.dataexecucao)'}">
            <div class="form-btns">
                <button type="submit" class="btn btn-medium btn-blue"><i class="fas fa-pencil-alt"></i> Editar
                    Tarefa</button>
            </div>
        </form>
    </section>
</main>