<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $success != ''  ){ ?>
        <div class="div-statusbar status-success">
            <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
            <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
        </div>
<?php } ?>
<header class="header">
    <h1 class="title">Listagem de Tarefas</h1>
</header>
<main class="main">
    <div class="header-options">
        <div class="btn-options">
            <a href="/areacolaboradores" class="btn btn-medium btn-blue"><i class="fa-solid fa-users"></i> Área de Colaboradores</a>
            <a href="/novatarefa" class="btn btn-medium btn-green"><i class="fa-solid fa-list-check"></i> Nova
                Tarefa</a>
        </div>
        <form action="/" class="form-search">
            <input type="text" class="input-search" placeholder="Prioridade, colaborador ou prazo" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>" name="search">
            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <section class="section">
        <table class="table">
            <thead class="thead">
                <tr class="th">
                    <th class="td">#</th>
                    <th class="td">Responsável</th>
                    <th class="td">Prioridade</th>
                    <th class="td">Data Prazo</th>
                    <th class="td">Descrição</th>
                    <th class="td">Ações</th>
                </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
                <?php $counter1=-1;  if( isset($taskslist) && ( is_array($taskslist) || $taskslist instanceof Traversable ) && sizeof($taskslist) ) foreach( $taskslist as $key1 => $value1 ){ $counter1++; ?>
                <tr class="tr">
                    <td class="td"><?php echo htmlspecialchars( $value1["idtarefa"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["prioridade"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo formatDate($value1["prazolimite"]); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["descricao"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td td-btns">
                        <a class="btn btn-min btn-red" href="/<?php echo htmlspecialchars( $value1["idtarefa"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/excluir" onclick="return confirm('Deseja realmente excluir a tarefa ?')"><i class="fa-solid fa-trash-can"></i> Excluir</a>
                    </td>
                </tr>
                <?php } ?>
                <?php if( $taskslist == [] ){ ?>
                <tr class="tr">
                    <td colspan="6" class="td">Não há dados cadastrados</td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="pagination">
            <?php $counter1=-1;  if( isset($pages) && ( is_array($pages) || $pages instanceof Traversable ) && sizeof($pages) ) foreach( $pages as $key1 => $value1 ){ $counter1++; ?>
            <a class="page" href="<?php echo htmlspecialchars( $value1["href"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><?php echo htmlspecialchars( $value1["text"], ENT_COMPAT, 'UTF-8', FALSE ); ?></a>
            <?php } ?>
        </div>
    </section>
</main>