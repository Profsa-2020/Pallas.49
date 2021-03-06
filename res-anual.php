<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">

<head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - Gerenciamento de Milhas - Alexandre Alves Rautemberg" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-11.png" sizes="32x32" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-12.png" sizes="50x50" />
     <link rel="icon" href="https://www.admmilhas.com.br/pallas49/img/logo-13.png" sizes="192x192" />
     <link rel="apple-touch-icon" href="https://www.admmilhas.com.br/pallas49/img/logo-14.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <link href="css/pallas49.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Conta Anual - Gerenciamento de Milhas - Alexandre Rautemberg - Profsa Informátda Ltda</title>
</head>

<script>
$(document).ready(function() {

     let usu = $('#usu').val();
     let pro = $('#pro').val();
     if (usu != 0) {
          $.get("ajax/carrega-pro.php", {
                    usu: usu,
                    pro: pro
               })
               .done(function(data) {
                    $('#pro').empty().html(data);
               });
     }

     $('#usu').change(function() {
          $('#tab-0 tbody').empty();
          let usu = $('#usu').val();
          $.get("ajax/carrega-pro.php", {
                    usu: usu
               })
               .done(function(data) {
                    $('#pro').empty().html(data);
               });
     });

     $('#pro').change(function() {
          $('#tab-0 tbody').empty();
     });

     $('#ano').change(function() {
          $('#tab-0 tbody').empty();
     });

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $ret = 0; $qtd_a = 0; $val_a = 0;
     $dad = array();
     include_once "dados.php";
     include_once "profsa.php";
     $_SESSION['wrknompro'] = __FILE__;
     date_default_timezone_set("America/Sao_Paulo");
     $ano = date('Y') - 4;
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrknomant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(10,"Entrada na página de Resumo por Contas Anual no sistema: " . $ano);  
          }
     }
     if (isset($_SESSION['wrkcodusu']) == false) { $_SESSION['wrkcodusu'] = 0; }
     if (isset($_SESSION['wrkcodpro']) == false) { $_SESSION['wrkcodpro'] = 0; }
     if (isset($_REQUEST['usu']) == true) { $_SESSION['wrkcodusu'] = $_REQUEST['usu']; }
     if (isset($_REQUEST['pro']) == true) { $_SESSION['wrkcodpro'] = $_REQUEST['pro']; }

     $usu = (isset($_REQUEST['usu']) == false ? $_SESSION['wrkcodusu'] : $_REQUEST['usu']);
     $pro = (isset($_REQUEST['pro']) == false ? $_SESSION['wrkcodpro'] : $_REQUEST['pro']);
     $ano = (isset($_REQUEST['ano']) == false ? date('Y') : $_REQUEST['ano']);

     if ($usu == 0 && $pro != 0) {
          echo '<script>alert("Não foi informado usuário para processamento de consulta !");</script>';
     } else if ($usu != 0 && $pro == 0) {
          echo '<script>alert("Não foi informado programa para processamento de consulta !");</script>';
     } else {
          $ret = carrega_mov($ano, $usu, $pro, $dad);
     }

?>

<body id="box00">
     <h1 class="cab-0">Resumo por Conta - Gerenciamento de Pontos e Milhas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="container-fluid">
          <div class="row">
               <div class="col-md-12">
                    <div class="container">
                         <form class="qua-2" id="frmTelCon" name="frmTelCon" action="" method="POST">
                              <p class="lit-4">Resumo por Conta Anual</p><br />
                              <div class="row">
                                   <div class="col-md-1"></div>
                                   <div class="col-md-2">
                                        <label>Ano Desejado</label><br />
                                        <select id="ano" name="ano" class="form-control">
                                             <?php
                                                  for ($ind = 0; $ind <= 10; $ind++) {
                                                       if (date('Y') != ($ano + $ind)) {
                                                            echo '<option value="' . ($ano + $ind) . '"> ' . ($ano + $ind) . '</option>';
                                                       } else {
                                                            echo '<option value="' . ($ano + $ind) . '" selected="selected"> ' . ($ano + $ind) . '</option>';
                                                       }
                                                  }
                                             ?>
                                        </select>
                                   </div>
                                   <div class="col-md-1"></div>
                                   <div class="col-md-3">
                                        <label>Usuário</label>
                                        <select id="usu" name="usu" class="form-control">
                                             <?php $ret = carrega_usu($usu); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-3">
                                        <label>Programa</label>
                                        <select id="pro" name="pro" class="form-control">
                                             <?php $ret = carrega_pro($usu, $pro); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-1"></div>
                                   <div class="col-md-1 text-center">
                                        <br />
                                        <button type="submit" id="con" name="consulta" class="bot-2"
                                             title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                                  class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                              <br />
                         </form>
                         <br /><br />
                         <div class="form-row text-center">
                              <div class="col-md-6">
                                   <p class="lit-c"><strong>COMPRAS / ENTRADAS - MOVIMENTO <?php echo $ano; ?></strong>
                                   </p>
                              </div>
                              <div class="col-md-6">
                                   <p class="lit-g"><strong>VENDAS / SAÍDAS - MOVIMENTO <?php echo $ano; ?></strong></p>
                              </div>
                         </div>
                         <div class="lit-i form-row">
                              <div class="col-md-2">
                                   <p>SALDO <?php echo $ano - 1; ?></p>
                              </div>
                              <div class="col-md-2">
                                   <p><?php echo number_format($qtd_a, 0, ",", "."); ?></p>
                              </div>
                              <div class="col-md-2">
                                   <p><?php echo 'R$ ' . number_format($val_a, 2, ",", "."); ?></p>
                              </div>
                              <div class="col-md-6"></div>
                         </div>
                         <br />
                         <div class="form-row">
                              <div class="col-md-6">
                                   <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                             <thead class="lit-e">
                                                  <tr>
                                                       <th>Mês</th>
                                                       <th>Milhas</th>
                                                       <th>Valor</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php 
                                             for ($ind = 1; $ind <= 12 ; $ind++) {
                                                  $txt =  '<tr>';
                                                  $txt .= '<td>' . $dad['mes_c'][$ind] . '</td>';
                                                  $txt .= '<td class="text-right">' . number_format($dad['qtd_c'][$ind], 0, ",", ".") . '</td>';
                                                  $txt .= '<td class="text-right">' . number_format($dad['val_c'][$ind], 2, ",", ".") . '</td>';
                                                  $txt .=  '</tr>';
                                                  echo $txt;
                                             }
                                             $txt =  '<tr class="lit-i">';
                                             $txt .= '<td class="text-right">' . 'TOTAL ENTRADAS ' . '</td>';
                                             $txt .= '<td class="text-right">' . number_format($dad['com_q'], 0, ",", ".") . '</td>';
                                             $txt .= '<td class="text-right">' . number_format($dad['com_v'], 2, ",", ".") . '</td>';
                                             $txt .=  '</tr>';
                                             echo $txt;
                                             $txt =  '<tr class="lit-e">';
                                             $txt .= '<td class="text-right">' . 'TOTAL GERAL ' . '</td>';
                                             $txt .= '<td class="text-right">' . number_format($dad['com_q'], 0, ",", ".") . '</td>';
                                             $txt .= '<td class="text-right">' . number_format($dad['com_v'], 2, ",", ".") . '</td>';
                                             $txt .=  '</tr>';
                                             echo $txt;
                                             ?>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                              <div class="col-md-6">
                                   <div class="table-responsive">
                                        <table class="table table-sm table-striped">
                                             <thead class="lit-e">
                                                  <tr>
                                                       <th>Mês</th>
                                                       <th>Milhas</th>
                                                       <th>Valor</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php 
                                                  for ($ind = 1; $ind <= 12 ; $ind++) {
                                                       $txt =  '<tr>';
                                                       $txt .= '<td>' . $dad['mes_v'][$ind] . '</td>';
                                                       $txt .= '<td class="text-right">' . number_format($dad['qtd_v'][$ind], 0, ",", ".") . '</td>';
                                                       $txt .= '<td class="text-right">' . number_format($dad['val_v'][$ind], 2, ",", ".") . '</td>';
                                                       $txt .=  '</tr>';
                                                       echo $txt;
                                                  }
                                                  $txt =  '<tr class="lit-e">';
                                                  $txt .= '<td class="text-right">' . 'TOTAL SAÍDAS ' . '</td>';
                                                  $txt .= '<td class="text-right">' . number_format($dad['ven_q'], 0, ",", ".") . '</td>';
                                                  $txt .= '<td class="text-right">' . number_format($dad['ven_v'], 2, ",", ".") . '</td>';
                                                  $txt .=  '</tr>';
                                                  echo $txt;     
                                                  ?>
                                             </tbody>
                                        </table>
                                   </div>

                              </div>
                         </div>

                         <div class="row text-center">
                              <div class="col-md-3">
                                   <div class="qua-c">
                                        <p>Custo Médio de Aquisição</p>
                                        <h3><?php echo number_format($dad['com_v'] / ($dad['com_q'] == 0 ? 1 : $dad['com_q']) * 1000, 2, ",", ".") ?>
                                        </h3>
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-c">
                                        <p>Saldo Disponível</p>
                                        <h3><?php echo number_format($dad['sdo_q'], 0,"," ,"."); ?></h3>
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-g">
                                        <p>Preço Médio de Venda</p>
                                        <h3><?php echo number_format($dad['ven_v'] / ($dad['ven_q'] == 0 ? 1 : $dad['ven_q']) * 1000, 2, ",", "."); ?>
                                        </h3>
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-g">
                                        <p>Custo Total das Vendas</p>
                                        <h3><?php echo 'R$ ' . number_format($dad['cus_m'], 2,"," ,"."); ?></h3>
                                   </div>
                              </div>
                         </div>

                         <div class="row text-center">
                              <div class="col-md-3"></div>
                              <div class="col-md-3">
                                   <div class="qua-d">
                                        <p>Capital em Saldo de Milhas</p>
                                        <h3><?php echo number_format($dad['sdo_v'], 2,"," ,"."); ?></h3>
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-h">
                                        <p>Lucro Bruto das Operações (R$)</p>
                                        <h3><?php echo 'R$ ' . number_format($dad['luc_r'], 2, ",", "."); ?></h3>
                                   </div>
                              </div>
                              <div class="col-md-3">
                                   <div class="qua-h">
                                        <p>Lucro Bruto das Operações (%)</p>
                                        <h3><?php echo number_format($dad['luc_p'], 2, ",", ".") . "%"; ?></h3>
                                   </div>
                              </div>
                         </div>
                         <br />
                    </div>
               </div>
          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>

<?php 
function carrega_usu($usu) {
     $sta = 0; $ant = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select idsenha, usunome from tb_usuario where usustatus = 0 and usuempresa = " . $_SESSION['wrkcodemp'] . " order by usunome, idsenha";
     } else {
          $com = "Select U.idsenha, U.usunome from (tb_usuario U left join tb_conta C on U.idsenha = C.conusuario) where usustatus = 0 and usuempresa = " . $_SESSION['wrkcodemp']  . "  and congerente = " . $_SESSION['wrkideusu'] . " order by U.usunome, U.idsenha";
     }
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($ant != $lin['idsenha']) {
               $ant = $lin['idsenha'];
               if ($lin['idsenha'] != $usu) {
                    echo  '<option value ="' . $lin['idsenha'] . '">' . $lin['usunome'] . '</option>'; 
               } else {
                    echo  '<option value ="' . $lin['idsenha'] . '" selected="selected">' . $lin['usunome'] . '</option>';
               }
          }
     }
     return $sta;
}

function carrega_pro($usu, $pro) {
     $sta = 0;
     include_once "dados.php";    
     echo '<option value="0" selected="selected">Selecione ...</option>';
     $com = "Select idprograma, prodescricao from tb_programa where prostatus = 0 and proempresa = " . $_SESSION['wrkcodemp'] . " order by prodescricao, idprograma";
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) {
          if ($lin['idprograma'] != $pro) {
               echo  '<option value ="' . $lin['idprograma'] . '">' . $lin['prodescricao'] . '</option>'; 
          } else {
               echo  '<option value ="' . $lin['idprograma'] . '" selected="selected">' . $lin['prodescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_mov($ano, $usu, $pro, &$dad) {
     include_once "dados.php";
     $dad['com_q'] = 0; $dad['com_v'] = 0; $dad['ven_q'] = 0; $dad['ven_v'] = 0;
     $dad['qua_a'] = 0; $dad['qua_v'] = 0; $dad['sdo_q'] = 0; $dad['sdo_v'] = 0;
     $dad['vlo_v'] = 0; $dad['cus_m'] = 0; $dad['luc_r'] = 0; $dad['luc_p'] = 0;
     for ($ind = 1; $ind <= 12 ; $ind++) {
          $dad['mes_c'][$ind] = mes_ano($ind);
          $dad['qtd_c'][$ind] = 0;
          $dad['val_c'][$ind] = 0;
          $dad['mes_v'][$ind] = mes_ano($ind);
          $dad['qtd_v'][$ind] = 0;
          $dad['val_v'][$ind] = 0;
     } 
     $dti = $ano . "-01-01"; $dtf = $ano . "-12-31";
     if ($usu == 0 && $pro == 0) {
          $com  = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movdata between '" . $dti . "' and '" . $dtf . "'";
     } else {
          $com  = "Select * from tb_movto where movempresa = " . $_SESSION['wrkcodemp'] . " and movusuario = " . $usu . " and movprograma = ". $pro . " and movdata between '" . $dti . "' and '" . $dtf . "'";
     }
     $nro = leitura_reg($com, $reg);
     foreach ($reg as $lin) { // 0-Compra 1-Transferência 2-Venda 3-Venda intermediario
          $mes = (int) date('m', strtotime($lin['movdata']));
          if ($lin['movtipo'] == 0) {
               $dad['qua_a'] += $lin['movquantidade'];
               $dad['com_q'] += $lin['movquantidade'];
               $dad['com_v'] += $lin['movvalor'];
               $dad['qtd_c'][$mes] += $lin['movquantidade'];
               $dad['val_c'][$mes] += $lin['movvalor'];
          }
          if ($lin['movtipo'] == 2) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qua_a'] += $lin['movquantidade'];
                    $dad['com_q'] += $lin['movquantidade'];
                    $dad['com_v'] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
                    $dad['qtd_c'][$mes] += $lin['movquantidade'];
                    $dad['val_c'][$mes] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
               }
          }
          if ($lin['movtipo'] == 3 || $lin['movtipo'] == 4) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qua_a'] += $lin['movquantidade'];
                    $dad['com_q'] += $lin['movquantidade'];
                    $dad['com_v'] += $lin['movquantidade'] * $lin['movcusto'];
                    $dad['qtd_c'][$mes] += $lin['movquantidade'];
                    $dad['val_c'][$mes] += $lin['movquantidade'] * $lin['movcusto'];
               }
          }
          if ($lin['movtipo'] == 7 || $lin['movtipo'] == 8) {
               if ($lin['movliquidado'] == 1) {
                    $dad['qua_a'] += $lin['movquantidade'];
                    $dad['com_q'] += $lin['movquantidade'];
                    $dad['com_v'] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
                    $dad['qtd_c'][$mes] += $lin['movquantidade'];
                    $dad['val_c'][$mes] += $lin['movquantidade'] * $lin['movcusto'] / 1000;
                    }
          }
          if ($lin['movtipo'] == 5) {
               $dad['vlo_v'] += $lin['movvalor'];
               $dad['qua_v'] += $lin['movquantidade'];
               $dad['ven_q'] += $lin['movquantidade'];
               $dad['ven_v'] += $lin['movvalor'];
               $dad['qtd_v'][$mes] += $lin['movquantidade'];
               $dad['val_v'][$mes] += $lin['movvalor'];
          }
     }

     $med = $dad['com_v'] / ($dad['com_q'] == 0 ? 1 :$dad['com_q']);   // Preço médio de compra
     $dad['sdo_q'] = $dad['qua_a'] - $dad['qua_v'];
     $dad['sdo_v'] = ($dad['qua_a'] - $dad['qua_v']) * $med;
     $dad['cus_m'] = $med * $dad['ven_q'];
     $dad['luc_r'] = $dad['vlo_v'] - $dad['cus_m'];
     if ($dad['cus_m'] != 0) {
          $dad['luc_p'] = $dad['luc_r'] / $dad['cus_m'] * 100;
     }
     return $nro;
}

?>

</html>