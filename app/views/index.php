<?
/**
 * @var Tasks[] $model
 * @var [] $pagination
 */

use App\models\Tasks;
use Lib\App;

$labels = Tasks::labels;
?>

<div class="row">
    <div class="col display-4">Список задач</div>
    <div class="mr-auto"></div>
    <button type="button" class="btn btn-primary m-3"
            data-toggle="modal"
            data-target="#editForm"
            data-id=""
            data-title=""
            data-task=""
            data-ready=""
            data-action="add"
    >+
    </button>
</div>
<ul class="pagination">
</ul>
<table class="table table-striped">
    <thead>
    <tr>
        <? foreach ($labels as $key => $label): ?>
            <th scope="col" style="cursor: pointer;" onclick="sort('<?= $key ?>')">
                <?= $label ?>
            </th>
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
                    <button type="button" class="btn btn-primary"
                            data-toggle="modal"
                            data-target="#editForm"
                            data-id="<?= $task->id ?>"
                            data-title="<?= $task->title ?>"
                            data-task="<?= $task->task ?>"
                            data-ready="<?= $task->ready ?>"
                            data-action="change"
                    >&#128393;
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
            <form action="<?=App::$config['HTTPRoot']?>">
                <div class="modal-body">
                    <input type="hidden" name="c" value="main">
                    <input type="hidden" name="m">
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
                    <button type="submit" class="btn btn-primary"></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var urlToPerams = function(){
        return window.location.search.replace('?', '').split('&').reduce(
            function (p, e) {
                var a = e.split('=');
                p[decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            }, {});
    };

    var sort = function (field) {
        var query = urlParams.field === field && !urlParams.order ? '&order=desc' : '';
        document.location = "<?=App::$config['HTTPRoot']?>/?c=main&m=index&field=" + field + query;
    };

    var paramsToUrl = function(key, value){
        let params = urlToPerams();
        params[key] = value;
        return "<?=App::$config['HTTPRoot']?>/?"+Object.keys(params).map(function(k){
            return k + '=' +params[k]
        }).join('&');
    };

    var urlParams = urlToPerams();

    $(document).ready(function () {
        var pag = $('.pagination');
        var page = urlParams['page'] * 1 || 0;
        var pages = <?=$pagination['pages'] + 0?>;

        page && pag.append('<li class="page-item">' +
            '<a class="page-link" href="' + paramsToUrl("page", 0) + '" aria-label="Previous">' +
            '  <span aria-hidden="true">&laquo;</span>' +
            '</a></li>');
        for (let num = page - 1; num < pages && (num <= page + 1); num++){
            if (num < 0){
                continue;
            }
            if (page === num){
                pag.append(
                    '<li class="page-item active"><span class="page-link">' + (num + 1) + '</span></li>'
                );
            } else {
                pag.append(
                    '<li class="page-item">' +
                        '<a class="page-link" href="' + paramsToUrl("page", num) + '">' + (num + 1) + '</a>' +
                    '</li>');
            }
        }
        page < pages - 1 && pag.append('<li class="page-item">' +
            '<a class="page-link" href="' + paramsToUrl("page", pages-1)+ '" aria-label="Next">' +
            '<span aria-hidden="true">&raquo;</span>' +
            '</a></li>')
    });

    $('#editForm').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget),
            modal = $(this),
            title = button.data('title'),
            task = button.data('task'),
            id = button.data('id'),
            ready = button.data('ready'),
            action = button.data('action')
        ;
        modal.find('.modal-title').text(id ? title : "Добавить запись");
        modal.find('.modal-body input[name="m"]').val(action);
        modal.find('.modal-body input[name="id"]').val(id);
        modal.find('.modal-body input[name="title"]').val(title);
        modal.find('.modal-body textarea[name="task"]').val(task);
        modal.find('.modal-body input[name="ready"]').prop('checked', ready);
        modal.find('.modal-footer button[type="submit"]').text(id ? 'Изменить' : 'Добавить');
    })
</script>