@extends('templates.home')

@section('content')
<div class="main">
    <div class="principal">
        <span
            style="font-size: 50px; font-weight: 700; color: #18518f; font-family: 'Open Sans Condensed', sans-serif;">Diário
            Oficial</span>
    </div>
    <div class="cadastro">
        <form action="#" method="post" name="frmcad" id="frmcad">
            <table class="table">
                <tr>
                    <td>
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" id="titulo">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="conteuo">Conteúdo</label>
                        <textarea name="conteudo" id="conteudo" cols="30" rows="5" class="form-control"></textarea>
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <button type="button" class="btn-primary" onclick="salvar()">Salvar</button>
                        &nbsp;&nbsp;
                        <button type="button" class="btn-primary" onclick="limpar()">Limpar Campos</button>
                        &nbsp;&nbsp;
                        <img src="{{ asset('img/loading.gif')}}" alt="" style="display: none" id="loader">
                    </td>
                </tr>
            </table>
            <input type="hidden" name="id" id="id" value="0">
        </form>
    </div>
    <div class="conteudo">
        <div class="titulo-exibicao">Diário do Dia</div>
        <div class="titulo-lista">Últimos Diários</div>
        <div class="conteudo-exibicao" id="detalhe"></div>
        <div class="conteudo-lista" id="lista"></div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        function salvar() {
            var titulo = $('#titulo').val();
            var conteudo = $('#conteudo').val();
            var id = $('#id').val();
            if(titulo == '') {
                alert('Preencha o Título');
                return $('#titulo').focus();
            }
            else if(conteudo == '') {
                alert('Preencha o Conteudo');
                return $('#conteudo').focus();
            }
            $('#loader').show();
            $.ajax({
                url: '{{ route('cadastro-json')}}',
                data: {
                    _token: '{{ csrf_token() }}',
                    titulo: titulo,
                    conteudo: conteudo,
                    id: id
                },
                type: 'json',
                method: 'post',
                success: function (r) {
                    //console.log(r);
                    let res = JSON.parse(r);
                    if (res == 1) {
                        $('#loader').hide();                        
                        alert('Operação realizada com sucesso !!');
                        $('#frmcad').each(function(){this.reset();});
                        renderizar();
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    document.getElementById('loading').style.display = 'false';
                    for (i in XMLHttpRequest) {
                        if (i != "channel")
                            console.log(i + " : " + XMLHttpRequest[i])
                    }
                }
            });
        }

        function renderizar() {
            $('#lista').html('<font style=font-size: 11px; margin: 0% auto;>Carregando...</font>');
            $.ajax({
                url: '{{ route('getdados-json')}}',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                type: 'json',
                method: 'post',
                success: function (r) {
                    $('#lista').html('');
                    //console.log(r);
                    //let res = JSON.parse(r);
                    var res = "<table calss='table' width='90%' style='margin: 0% auto; margin-top: 10px;' cellpadding='4'>";
                    if (r.length > 0) {
                        for(i=0;i<r.length;i++) {
                            res += "    <tr style='height: 25px;'>";
                            res += "        <td style='font-size: 11px; width: 70%'>"+r[i].title+"</td>";
                            res += "        <td style='width: 10%'>&nbsp;</td>";
                            res += "        <td style='width: 10%; text-align-center'><button onclick='visualizar("+r[i].id+")' style='border: 0' title='Visualizar'><i class='fa fa-eye' style='color: #20B2AA'></i></button></td>";
                            res += "        <td style='width: 10%'><button onclick='editar("+r[i].id+")' style='border: 0' title='Editar'><i class='fa fa-pencil' style='color: #808080'></i></button></td>";
                            res += "        <td style='width: 10%'><a href='pdf-detalhe/"+r[i].id+"' target='_blank' title='Gerar PDF'><i class='fa fa-file-pdf' style='color:	#A9A9A9'></i></a></td>";
                            res += "        <td style='width: 10%'><button onclick='excluir("+r[i].id+")' style='border: 0' title='Excluir'><i class='fa fa-remove' style='color:red'></i></button></td>";
                            res += "    </tr>";
                        }                        
                    }
                    else {
                        res += "    <tr>";
                        res += "        <td></td>";
                        res += "    </tr>";
                    }
                    res += "  </table>";
                    $('#lista').html(res);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    document.getElementById('loading').style.display = 'false';
                    for (i in XMLHttpRequest) {
                        if (i != "channel")
                            console.log(i + " : " + XMLHttpRequest[i])
                    }
                }
            });
        }

        function editar(id) {
            $.ajax({
                url: '{{ route('edit-json')}}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                type: 'json',
                method: 'post',
                success: function (r) {
                    //console.log(r);
                    //let res = JSON.parse(r);
                    $('#titulo').val(r.title);
                    $('#conteudo').val(r.content);
                    $('#id').val(r.id);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    document.getElementById('loading').style.display = 'false';
                    for (i in XMLHttpRequest) {
                        if (i != "channel")
                            console.log(i + " : " + XMLHttpRequest[i])
                    }
                }
            });
        }     
        
        function visualizar(id) {
            $.ajax({
                url: '{{ route('show-json')}}',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                type: 'json',
                method: 'post',
                success: function (r) {
                    //console.log(r);
                    //let res = JSON.parse(r);
                    var res = "<table calss='table' width='90%' style='margin: 0% auto;'";
                    res += "    <tr>";
                    res += "        <td style='font-size: 11px; width: 70%'; text-align='center'>"+r.title+"</td>";
                    res += "    </tr>";
                    res += "    <tr>";
                    res += "        <td style='font-size: 11px; width: 70%; text-align='justify'>"+r.content+"</td>";
                    res += "    </tr>";
                    res += "  </table>";
                    $('#detalhe').html(res);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    document.getElementById('loading').style.display = 'false';
                    for (i in XMLHttpRequest) {
                        if (i != "channel")
                            console.log(i + " : " + XMLHttpRequest[i])
                    }
                }
            });
        }     

        function excluir(id) {
            if(confirm('Deseja realmente excluir esse registro?')) {
                $.ajax({
                    url: '{{ route('delete-json')}}',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    type: 'json',
                    method: 'post',
                    success: function (r) {
                        console.log(r);
                        if(r == 1) {
                            alert('Registro excluido com sucesso');
                        }
                        else {
                            alert('Falha ao exluir o registro');
                        }
                        renderizar();
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        document.getElementById('loading').style.display = 'false';
                        for (i in XMLHttpRequest) {
                            if (i != "channel")
                                console.log(i + " : " + XMLHttpRequest[i])
                        }
                    }
                });
            }
        }     

        function limpar() {
            $('#frmcad').each(function(){this.reset();});
            $('#id').val(0);
            $('#detalhe').html('');
        }
        window.onload = renderizar();
    </script>
@endsection