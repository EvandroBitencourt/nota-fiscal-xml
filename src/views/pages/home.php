<?php $render('header'); ?>

<section class="emitidos">
        <div class="">
            <a href="<?=$base?>/new" type="button" class="btn">Upload de XML</a>
        </div>
        <div>
            <h1>Doc. Emitidos</h1>
         
            <table>
                <thead>
                    <tr>
                        <th>Destinatário</th>
                        <th>Núm/Série</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach($notas as $nota): ?>
                    <tr>
                        <td><?= $nota['destinatario'] ?></td>
                        <td> <?= $nota['num'] ?></td>
                        <td><?= implode('/', array_reverse(explode('-', $nota['data']))) ?></td>
                        <td>R$ <?= $nota['valor'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
     
        </div>
    </section>

<?php $render('footer'); ?>