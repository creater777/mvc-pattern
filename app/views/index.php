<?
/**
 * @var Tasks[] $model
 */

use App\models\Tasks;
use Lib\App;

$labels = Tasks::labels;
?>
<h1>Список задач</h1>
<table class="table table-striped">
    <thead>
    <tr>
        <? foreach ($labels as $key => $label): ?>
            <th scope="col"><?= $label ?></th>
        <? endforeach; ?>
        <? if (App::userIsLogged()): ?>
            <th scope="col">Действие</th>
        <? endif; ?>
    </tr>
    </thead>
    <tbody>
    <? foreach ($model as $task): ?>
        <tr class="<?= $task->ready ? "table-success" : "" ?>">
            <? foreach ($labels as $key => $label): ?>
                <td scope="row"><?= $task->$key ?></td>
            <? endforeach; ?>
            <? if (App::userIsLogged()): ?>
                <td>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editForm"
                            data-id="<?= $task->id ?>"
                            data-title="<?= $task->title ?>"
                            data-task="<?= $task->task ?>"
                            data-ready="<?= $task->ready ?>"
                    >Редактировать
                    </button>
                </td>
            <? endif; ?>
        </tr>
    <? endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="editFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFormLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Закрыть">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="/web">
                <div class="modal-body">
                    <input type="hidden" name="c" value="main">
                    <input type="hidden" name="m" value="change">
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label class="col-form-label">Задача:</label>
                        <input type="text" class="form-control" name="title">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label">Описание:</label>
                        <textarea class="form-control" name="task"></textarea>
                    </div>
                    <div class="form-group form-check-inline">
                        <label class="col-form-label">Выполненно:</label>
                        <input type="checkbox" class="ml-2" name="ready">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Изменить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editForm').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var title = button.data('title'),
            task = button.data('task'),
            id = button.data('id'),
            ready = button.data('ready')
        ;
        console.log(ready)
        var modal = $(this);
        modal.find('.modal-title').text(title);
        modal.find('.modal-body input[name="id"]').val(id);
        modal.find('.modal-body input[name="title"]').val(title);
        modal.find('.modal-body textarea[name="task"]').val(task);
        modal.find('.modal-body input[name="ready"]').prop('checked', ready);
    })
</script>