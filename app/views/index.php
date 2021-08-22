<?
/**
 * @var $model Tasks[]
 */

use App\models\Tasks;

$labels = Tasks::labels;
?>
<h1>Список задач</h1>
<table class="table table-striped">
    <thead>
    <tr>
        <? foreach ($labels as $key => $label): ?>
            <th scope="col"><?= $label ?></th>
        <? endforeach; ?>
    </tr>
    </thead>
    <tbody>
    <? foreach ($model as $task): ?>
        <tr>
            <? foreach ($labels as $key => $label): ?>
                <td scope="row"><?= $task->$key ?></td>
            <? endforeach; ?>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>
