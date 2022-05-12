<?php if(!class_exists('Rain\Tpl')){exit;}?><?php if( $success != ''  ){ ?>
<div class="div-statusbar status-success">
    <span class="statusbar-msg"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?></span>
    <span class="close-statusbar" onclick="closestatusbar();"><i class="fas fa-times"></i></span>
</div>
<?php } ?>
<header class="header">
    <h1 class="title">Área de Colaboradores</h1>
</header>
<main class="main">
    <div class="header-options">
        <div class="btn-options">
            <a href="/areacolaboradores/novocolaborador" class="btn btn-medium btn-green"><i
                    class="fa-solid fa-user-plus"></i> Cadastrar Colaborador</a>
            <a href="/" class="btn btn-medium btn-blue"><i class="fa-solid fa-list-check"></i> Tarefas</a>
        </div>
        <form action="/areacolaboradores" class="form-search">
            <input type="text" class="input-search" placeholder="Pesquisar por Nome" name="search" value="<?php echo htmlspecialchars( $search, ENT_COMPAT, 'UTF-8', FALSE ); ?>">
            <button type="submit" class="btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
        </form>
    </div>
    <section class="section">
        <table class="table">
            <thead class="thead">
                <tr class="th">
                    <th class="td">#</th>
                    <th class="td">Nome</th>
                    <th class="td">CPF</th>
                    <th class="td">Email</th>
                    <th class="td">Ações</th>
                </tr>
            </thead>
            <tfoot>

            </tfoot>
            <tbody>
                <?php $counter1=-1;  if( isset($employeeslist) && ( is_array($employeeslist) || $employeeslist instanceof Traversable ) && sizeof($employeeslist) ) foreach( $employeeslist as $key1 => $value1 ){ $counter1++; ?>
                <tr class="tr">
                    <td class="td"><?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["cpf"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td"><?php echo htmlspecialchars( $value1["email"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                    <td class="td td-btns">
                        <a class="btn btn-min btn-blue" href="/areacolaboradores/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/editarcolaborador"><i
                                class="fa-solid fa-pen-to-square"></i> Editar</a>
                        <a class="btn btn-min btn-red" href="/areacolaboradores/<?php echo htmlspecialchars( $value1["id"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/excluir"
                            onclick="return confirm('Deseja realmente excluir o colaborador <?php echo htmlspecialchars( $value1["nome"], ENT_COMPAT, 'UTF-8', FALSE ); ?> ?')"><i
                                class="fa-solid fa-trash-can"></i> Excluir</a>
                    </td>
                </tr>
                <?php } ?>
                <?php if( $employeeslist == [] ){ ?>
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