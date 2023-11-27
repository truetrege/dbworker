const TableCreator = (tableName) => {
    const table = $('<table class="table table-responsive" />');
    const label = $('<h5/>').text('Table:' + tableName);

    table.attr('id', tableName);
    table.append('<thead><tr></tr></thead><tbody><tfoot><tr></tr></tfoot></tbody>')
    $('#tableContainer').append(label).append(table);

    return table;
}
const TableRender = (name, rows, headers) => {
    const table = $('table#' + name);
    const body = table.find('tbody');
    const header = table.find('thead tr');
    const footer = table.find('tfoot tr');

    table.data('name',name)
    body.empty()
    header.empty()
    footer.empty()

    headers.forEach((element) => {
        const th = $('<th />').text(element);
        header.append(th);

        const input = $('<input class="form-control" type="text"/>')
        if (element === 'id') {
            input.attr('disabled', true)
        }
        input.data('name',element)
        const td = $('<td />').append(input);
        footer.append(td)
    });
    footer.append('<td><button class="btn btn-primary new">New</button></td>')

    header.append('<th>Actions</th>');
    rows.forEach((row) => {
        const tr = $('<tr />');
        for (key in row) {
            const input = $('<input class="form-control" type="text"/>').val(row[key])
            input.data('name',key)
            if (key === 'id') {
                input.attr('disabled', true)
            }
            const td = $('<td />').append(input);
            if (key === 'color') {
                tr.css('background-color', row[key]);
            }
            tr.append(td);
        }
        const actions = $('<td style="background-color: white">');
        const edit = $('<button class="btn btn-outline-primary edit">Edit</button>');
        const randColor = $('<button class="btn btn-outline-warning randColor">RandColor</button>');
        const defColor = $('<button class="btn btn-outline-secondary defColor">DefColor</button>');
        const deleteB = $('<button class="btn btn-outline-danger delete">Delete</button>');

        actions.append(edit).append(randColor).append(defColor).append(deleteB);
        tr.append(actions);
        body.append(tr);
    });
}
const LoaderTables = () => {
    $.ajax({
        type: "POST",
        url: '/all',
        data: {},
        success: (data) => {
            data.forEach((element) => {
                TableCreator(element);
                LoaderTable(element);
            })
        }
    });
}
const LoaderTable = (table) => {

    $.ajax({
        type: "POST",
        url: '/get',
        data: {table: table},
        success: (data) => {
            TableRender(data.table, data.rows, data.headers);
        }
    });
}
const ActionRow = (data,action) => {
    const url = '/'+action;

    $.ajax({
        type: "POST",
        url: url,
        data: data,
        success: (data) => {
            if(data.table){
                LoaderTable(data.table);
            }
        }
    });
}
const SetColorRow = (target,color)=>{
    const row = $(target).parent().parent()
    row.find('input').each((i,element)=>{
        const name = $(element).data('name');
        if(name === 'color') {
            $(element).val(color);
        }
    })
}
const RandomColor = ()=>{
  return "#" + Math.floor(Math.random()*16777215).toString(16).padStart(6, '0').toUpperCase();
}


$('body').on('click','.randColor',(event)=>{
    const row = $(event.target).parent().parent()
    const table = row.parent().parent()
    const color = RandomColor();
    SetColorRow(event.target,color)
    row.find('.edit').click();
});
$('body').on('click','.defColor',(event)=>{
    const row = $(event.target).parent().parent()

    SetColorRow(event.target,'#FFFFFF')
    row.find('.edit').click();
});
$('body').on('click','.edit, .new, .delete',(event)=>{
    const row = $(event.target).parent().parent()
    const table = row.parent().parent()
    const data = {
        table:table.data('name'),
        values: {},
        where: {}
    }
    row.find('input').each((i,element)=>{
        const name = $(element).data('name');
        if(name === 'id') {
            data.where[name]= $(element).val()
        }
            data.values[name]= $(element).val();
    })

    if($(event.target).hasClass('edit')){

        ActionRow(data,'update');
    }else if($(event.target).hasClass('new')){

        ActionRow(data,'insert');
    }else if($(event.target).hasClass('delete')){

        ActionRow(data,'delete');
    }

})


$(window).on("load", function () {
        LoaderTables();
    }
);
