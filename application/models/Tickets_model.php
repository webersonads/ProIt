<?php

class Tickets_model extends CI_Model{

    public function listarChamadosGeral($dataInicial,$dataFinal,$status){

        if($status != ""){
            if($status == "99"){
                $strWhere = "AND t.status IN ('1','2','3','4','5','6')
                             AND t.is_deleted = 1 ";
            }else{ 
                $strWhere = "AND t.status = '$status'
                             AND t.is_deleted = 0 ";
            }
        }else{
            $strWhere = "AND status IN ('1','2','3','4') AND t.is_deleted = 0 AND status not in ('99') ";
        }

        if($dataInicial != ""){
            $strWhereDatas = "AND t.date_creation >= '$dataInicial 00:00:00'
                              AND t.date_creation <= '$dataFinal 23:59:59'";
        }else{
            $strWhereDatas = "";
        }

        date_default_timezone_set('America/Sao_Paulo');

        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT numeroChamado,
        dataAbertura2,
        solvedate2,
        titulo,
        dataAbertura,
        closedate,
        solvedate,
        datemode,
        status,
        codStatus,
        excluido,
        nomeUsuario,
        tecnico,
        observador,
        categoria,
        urgencia,
        tipo,
        impacto
        FROM (
        SELECT DISTINCT 
        t.id as numeroChamado,
        t.name as titulo,
        t.date as dataAbertura2,
        t.solvedate as solvedate2,
        t.date as dataAbertura1,
        DATE_FORMAT(t.date, '%d/%m/%Y %H:%m:%s') as dataAbertura,
        DATE_FORMAT(t.closedate, '%d/%m/%Y %H:%m:%s') as closedate,
        t.solvedate,
        DATE_FORMAT(t.date_mod, '%d/%m/%Y %H:%m:%s') as datemode,
        CASE WHEN t.type = 1 THEN 'Incidente'
             WHEN t.type = 2 THEN 'Requisicao' END AS tipo,
        CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
             WHEN t.urgency = 2 THEN 'Baixa' 
             WHEN t.urgency = 3 THEN 'Media'
             WHEN t.urgency = 4 THEN 'Alta'
             WHEN t.urgency = 5 THEN 'Muito Alta'
             end as urgencia,
        CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
             WHEN t.urgency = 2 THEN 'Baixo' 
             WHEN t.urgency = 3 THEN 'Medio'
             WHEN t.urgency = 4 THEN 'Alto'
             WHEN t.urgency = 5 THEN 'Muito Alto'
             end as impacto,
        CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '2' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '3' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '4' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '5' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '6' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '1' AND t.is_deleted = 0 THEN 'Novo'
        WHEN t.status = '2' AND t.is_deleted = 0 THEN 'Em atendimento (atribuido)'
        WHEN t.status = '3' AND t.is_deleted = 0 THEN 'Em atendimento (planejado)'
        WHEN t.status = '4' AND t.is_deleted = 0 THEN 'Pendente'
        WHEN t.status = '5' AND t.is_deleted = 0 THEN 'Solucionado'
        WHEN t.status = '6' AND t.is_deleted = 0 THEN 'Fechado'
        end as status,
        CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '2' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '3' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '4' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '5' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '6' AND t.is_deleted = 1 THEN 99
            else t.status end as codStatus,
        t.is_deleted as excluido,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1
        WHERE gtu.tickets_id = t.id limit 1) as nomeUsuario,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 2
        WHERE gtu.tickets_id = t.id limit 1) as tecnico,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 3
        WHERE gtu.tickets_id = t.id limit 1) as observador,
        cat.name as categoria
        FROM glpi_tickets t
        LEFT JOIN glpi_tickets_users gtu ON gtu.tickets_id = t.id
        LEFT JOIN glpi_users u ON u.id = gtu.users_id and gtu.type = 1
        LEFT JOIN glpi_users atend ON atend.id = gtu.users_id and gtu.type = 2  
        LEFT JOIN glpi_users observ ON observ.id = gtu.users_id and gtu.type = 3
        LEFT JOIN glpi_itilcategories cat ON cat.id = t.itilcategories_id
        INNER JOIN glpi_entities g on g.id = u.entities_id
        WHERE 1 = 1
        $strWhere 
        $strWhereDatas) AS QUERYA
        
        ORDER BY numeroChamado DESC ";   
        $query = $db_cli->query($SQL);
        return $query->result_array();
    }

    public function listarChamadosUsuarios($perfil, $entidade, $usuario,$dataInicial,$dataFinal,$status){
        date_default_timezone_set('America/Sao_Paulo');

        if($status != ""){
            if($status == "99"){
                $strWhere = "AND t.status IN ('1','2','3','4','5','6')
                             AND t.is_deleted = 1 ";
            }else{ 
                $strWhere = "AND t.status = '$status'
                             AND t.is_deleted = 0 ";
            }
        }else{
            $strWhere = "AND t.status IN ('1','2','3','4','5','6') 
            AND t.is_deleted = 0 AND t.status not in ('99') ";
        }

        if($dataInicial != ""){
            $strWhereDatas = "AND t.date_creation >= '$dataInicial 00:00:00'
                              AND t.date_creation <= '$dataFinal 23:59:59'";
        }else{
            $strWhereDatas = "";
        }

        // if($perfil == "adminemp"){
            $strWhere2 = "AND t.entities_id = '$entidade'";
        // }else{
            // $strWhere2 = "AND nomeUsuario = '$usuario'";
        // }
               
        
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT numeroChamado,
        titulo,
        dataAbertura,
        closedate,
        solvedate,
        datemode,
        status,
        codStatus,
        excluido,
        nomeUsuario,
        firstname,
        lastname,
        tecnico,
        observador,
        categoria,
        urgencia,
        tipo,
        impacto,
        is_deleted
        FROM (
        SELECT DISTINCT 
        t.id as numeroChamado,
        t.name as titulo,
        t.date as dataAbertura1,
        DATE_FORMAT(t.date, '%d/%m/%Y %H:%m:%s') as dataAbertura,
        DATE_FORMAT(t.closedate, '%d/%m/%Y %H:%m:%s') as closedate,
        t.solvedate,
        DATE_FORMAT(t.date_mod, '%d/%m/%Y %H:%m:%s') as datemode,
        CASE WHEN t.type = 1 THEN 'Incidente'
             WHEN t.type = 2 THEN 'Requisicao' END AS tipo,
        CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
             WHEN t.urgency = 2 THEN 'Baixa' 
             WHEN t.urgency = 3 THEN 'Media'
             WHEN t.urgency = 4 THEN 'Alta'
             WHEN t.urgency = 5 THEN 'Muito Alta'
             end as urgencia,
        CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
             WHEN t.urgency = 2 THEN 'Baixo' 
             WHEN t.urgency = 3 THEN 'Medio'
             WHEN t.urgency = 4 THEN 'Alto'
             WHEN t.urgency = 5 THEN 'Muito Alto'
             end as impacto,
        CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '2' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '3' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '4' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '5' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '6' AND t.is_deleted = 1 THEN 'Excluido'
        WHEN t.status = '1' AND t.is_deleted = 0 THEN 'Novo'
        WHEN t.status = '2' AND t.is_deleted = 0 THEN 'Em atendimento (atribuido)'
        WHEN t.status = '3' AND t.is_deleted = 0 THEN 'Em atendimento (planejado)'
        WHEN t.status = '4' AND t.is_deleted = 0 THEN 'Pendente'
        WHEN t.status = '5' AND t.is_deleted = 0 THEN 'Solucionado'
        WHEN t.status = '6' AND t.is_deleted = 0 THEN 'Fechado'
        end as status,
        CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '2' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '3' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '4' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '5' AND t.is_deleted = 1 THEN 99
        WHEN t.status = '6' AND t.is_deleted = 1 THEN 99
            else t.status end as codStatus,
        t.is_deleted as excluido,
        t.is_deleted,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1
        WHERE gtu.tickets_id = t.id limit 1) as nomeUsuario,
        (SELECT gu.firstname
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1
        WHERE gtu.tickets_id = t.id limit 1) as firstname,
        (SELECT gu.realname
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1
        WHERE gtu.tickets_id = t.id limit 1) as lastname,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 2
        WHERE gtu.tickets_id = t.id limit 1) as tecnico,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 3
        WHERE gtu.tickets_id = t.id limit 1) as observador,
        cat.name as categoria,
        t.entities_id as entidade
        FROM glpi_tickets t
        LEFT JOIN glpi_tickets_users gtu ON gtu.tickets_id = t.id
        LEFT JOIN glpi_users u ON u.id = gtu.users_id and gtu.type = 1
        LEFT JOIN glpi_users atend ON atend.id = gtu.users_id and gtu.type = 2  
        LEFT JOIN glpi_users observ ON observ.id = gtu.users_id and gtu.type = 3
        LEFT JOIN glpi_itilcategories cat ON cat.id = t.itilcategories_id
        INNER JOIN glpi_entities g on g.id = u.entities_id
        WHERE 1 = 1
        $strWhere 
        $strWhereDatas  
        $strWhere2
        ) AS QUERY
        WHERE 1 = 1  
        ORDER BY numeroChamado DESC "; 

        $query = $db_cli->query($SQL);
        return $query->result_array();
    }

    public function detalheChamado($idticket){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select("t.id as numeroChamado,
        t.name as titulo,
        DATE_FORMAT(t.date, '%d/%m/%Y %H:%m:%s') as dataAbertura,
        DATE_FORMAT(t.closedate, '%d/%m/%Y %H:%m:%s') as closedate,
        DATE_FORMAT(t.solvedate, '%d/%m/%Y %H:%m:%s') as solvedate,
        DATE_FORMAT(t.date_mod, '%d/%m/%Y') as datemode,
        CASE WHEN t.status = '1' THEN 'Novo'
             WHEN t.status = '2' THEN 'Em atendimento (atribuido)'
             WHEN t.status = '3' THEN 'Em atendimento (planejado)'
             WHEN t.status = '4' THEN 'Pendente'
             WHEN t.status = '5' THEN 'Solucionado'
             WHEN t.status = '6' THEN 'Fechado' end as status,
        t.status as codStatus,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1
        WHERE gtu.tickets_id = t.id limit 1) as nomeUsuario,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 2
        WHERE gtu.tickets_id = t.id limit 1) as tecnico,
        (SELECT 
        gu.name
        FROM glpi_tickets_users gtu
        INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 3
        WHERE gtu.tickets_id = t.id limit 1) as observador,
        cat.name as categoria,
        REPLACE(REPLACE(REPLACE(t.content, '&lt;', '<'),'&quot;','\''),'&gt;','>') as content,
        doc.name as nomeArquivo,
        doc.id as idArquivo,
        CASE WHEN t.type = 1 THEN 'Incidente'
             WHEN t.type = 2 THEN 'Requisicao' END AS tipo,
        CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
             WHEN t.urgency = 2 THEN 'Baixa' 
             WHEN t.urgency = 3 THEN 'Media'
             WHEN t.urgency = 4 THEN 'Alta'
             WHEN t.urgency = 5 THEN 'Muito Alta'
             end as urgencia,
        CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
             WHEN t.urgency = 2 THEN 'Baixo' 
             WHEN t.urgency = 3 THEN 'Medio'
             WHEN t.urgency = 4 THEN 'Alto'
             WHEN t.urgency = 5 THEN 'Muito Alto'
             end as impacto,
        doc.filepath,
        doc.filename as arquivo ");   
        $db_cli->join('glpi_tickets_users gtu', 'gtu.tickets_id = t.id', 'LEFT');     
        $db_cli->join('glpi_users u', 'u.id = gtu.users_id and gtu.type = 1', 'LEFT');     
        $db_cli->join('glpi_users atend', 'atend.id = gtu.users_id and gtu.type = 2', 'LEFT');     
        $db_cli->join('glpi_users observ', 'observ.id = gtu.users_id and gtu.type = 3', 'LEFT');     
        $db_cli->join('glpi_itilcategories cat', 'cat.id = t.itilcategories_id', 'LEFT');     
        $db_cli->join('glpi_documents_items gitem', 'gitem.items_id = t.id and gitem.itemtype = "Ticket"', 'LEFT');     
        $db_cli->join('glpi_documents doc', 'doc.id = gitem.documents_id', 'LEFT');     
        $db_cli->join('glpi_entities g', 'g.id = u.entities_id', 'LEFT');     
        $db_cli->where('t.id',$idticket);
        $db_cli->order_by('t.date');   
        return $db_cli->get("glpi_tickets t")->result_array();
    }

    public function detalheChamadomensagens($idticket){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->distinct();
        $db_cli->select('
                        REPLACE(REPLACE(REPLACE( gi.content, "&lt;", "<"),"&quot;","\'"),"&gt;",">") as mensagem,
                        gi.date_creation,
                        gu.name as cliente,
                        atend.name as tecnico,
                        gtu.type,
                        gitem.documents_id,
                        doc.filepath as caminho,
                        doc.filename as nomeArquivo');   
        $db_cli->join('glpi_tickets t', 't.id = gi.items_id', 'inner');     
        $db_cli->join('glpi_users gu', 'gu.id = gi.users_id', 'LEFT');     
        $db_cli->join('glpi_tickets_users gtu', 'gtu.users_id = gu.id and gtu.`type` = 2', 'LEFT');     
        $db_cli->join('glpi_users atend', 'atend.id = gtu.users_id ', 'LEFT');     
        $db_cli->join('glpi_documents_items gitem', 'gitem.items_id = gi.id', 'LEFT');     
        $db_cli->join('glpi_documents doc', 'doc.id =gitem.documents_id', 'LEFT');     
        $db_cli->where('gi.items_id',$idticket);
        $db_cli->order_by('gi.date_creation DESC' );   
        return $db_cli->get("glpi_itilfollowups gi")->result_array();
    }

    public function detalheChamadoFollowyp($idticket){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select(' DATE_FORMAT(flw.date, "%d/%m/%Y %H:%m:%s") as data,
                            REPLACE(REPLACE(REPLACE(flw.content, "&lt;", "<"),"&quot;","\'"),"&gt;",">") as content,
                            u.name as tecnico ');   
        $db_cli->join('glpi_users u', 'u.id = flw.users_id', 'INNER');     
        $db_cli->where('flw.items_id',$idticket);
        $db_cli->order_by('flw.date');   
        return $db_cli->get("glpi_itilfollowups flw")->result_array();
    }

    public function totalizadoChamados($dataInicial,$dataFinal,$status,$entidade){

        if($status != ""){
            if($status == "99"){
                $strWhere = "AND t.status IN ('1','2','3','4','5','6')
                            AND t.is_deleted = 1 ";
            }else{ 
                $strWhere = "AND t.status = '$status'
                            AND t.is_deleted = 0 ";
            }
        }else{
            $strWhere = "AND t.status IN ('1','2','3','4','5','6') AND t.is_deleted = 0 AND status not in ('99') ";
        }

        if($dataInicial != ""){
            $strWhereDatas = "AND t.date >= '$dataInicial 00:00:00'
                              AND t.date <= '$dataFinal 23:59:59' ";
        }else{
            $strWhereDatas = "";
        }

        $strWhere2 = "AND t.entities_id = '$entidade'";
        
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT 
                count(*) as total,
                status,
                codStatus
                FROM (
                SELECT DISTINCT 
                t.id as numeroChamado,
                t.name as titulo,
                DATE_FORMAT(t.date, '%d/%m/%Y %H:%m:%s') as dataAbertura,
                DATE_FORMAT(t.closedate, '%d/%m/%Y') as closedate,
                DATE_FORMAT(t.solvedate, '%d/%m/%Y') as solvedate,
                CASE WHEN t.type = 1 THEN 'Incidente'
                    WHEN t.type = 2 THEN 'Requisicao' END AS tipo,
                CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
                    WHEN t.urgency = 2 THEN 'Baixa' 
                    WHEN t.urgency = 3 THEN 'Media'
                    WHEN t.urgency = 4 THEN 'Alta'
                    WHEN t.urgency = 5 THEN 'Muito Alta'
                    end as urgencia,
                CASE WHEN t.urgency = 1 THEN 'Muito Baixo'
                    WHEN t.urgency = 2 THEN 'Baixo' 
                    WHEN t.urgency = 3 THEN 'Medio'
                    WHEN t.urgency = 4 THEN 'Alto'
                    WHEN t.urgency = 5 THEN 'Muito Alto'
                    end as impacto,
                CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '2' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '3' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '4' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '5' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '6' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '1' AND t.is_deleted = 0 THEN 'Novo'
                WHEN t.status = '2' AND t.is_deleted = 0 THEN 'Em atendimento (atribuido)'
                WHEN t.status = '3' AND t.is_deleted = 0 THEN 'Em atendimento (planejado)'
                WHEN t.status = '4' AND t.is_deleted = 0 THEN 'Pendente'
                WHEN t.status = '5' AND t.is_deleted = 0 THEN 'Solucionado'
                WHEN t.status = '6' AND t.is_deleted = 0 THEN 'Fechado'
                end as status,
                CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 99
                WHEN t.status = '2' AND t.is_deleted = 1 THEN 99
                WHEN t.status = '3' AND t.is_deleted = 1 THEN 99
                WHEN t.status = '4' AND t.is_deleted = 1 THEN 99
                WHEN t.status = '5' AND t.is_deleted = 1 THEN 99
                WHEN t.status = '6' AND t.is_deleted = 1 THEN 99
                    else t.status end as codStatus,
                t.is_deleted as excluido,
                t.is_deleted,
                (SELECT 
                gu.name
                FROM glpi_tickets_users gtu
                INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1
                WHERE gtu.tickets_id = t.id limit 1) as nomeUsuario,
                (SELECT 
                gu.name
                FROM glpi_tickets_users gtu
                INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 2
                WHERE gtu.tickets_id = t.id limit 1) as tecnico,
                (SELECT 
                gu.name
                FROM glpi_tickets_users gtu
                INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 3
                WHERE gtu.tickets_id = t.id limit 1) as observador,
                cat.name as categoria
                FROM glpi_tickets t
                LEFT JOIN glpi_tickets_users gtu ON gtu.tickets_id = t.id
                LEFT JOIN glpi_users u ON u.id = gtu.users_id and gtu.type = 1
                LEFT JOIN glpi_users atend ON atend.id = gtu.users_id and gtu.type = 2  
                LEFT JOIN glpi_users observ ON observ.id = gtu.users_id and gtu.type = 3
                LEFT JOIN glpi_itilcategories cat ON cat.id = t.itilcategories_id  
                WHERE 1 = 1
                $strWhereDatas
                $strWhere
                $strWhere2 ) AS QUERY                
                GROUP BY status,
                codStatus ";

                $query = $db_cli->query($SQL);
                return $query->result_array();
    }

   public function totalizadoChamadosGeral($dataInicial,$dataFinal,$status){

        if($status != ""){
            if($status == "99"){
                $strWhere = "AND t.status IN ('1','2','3','4','5','6')
                            AND t.is_deleted = 1 ";
            }else{ 
                $strWhere = "AND t.status = '$status'
                            AND t.is_deleted = 0 ";
            }
        }else{
            $strWhere = "AND status IN ('1','2','3','4') AND t.is_deleted = 0 AND status not in ('99') ";
        }

        if($dataInicial != ""){
            $strWhereDatas = "AND t.date >= '$dataInicial 00:00:00'
                            and t.date <= '$dataFinal 23:59:59'";
        }else{
            $strWhereDatas = "";
        }
        
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT  
                count(*) as total,
                codStatus,
                status 
                FROM ( 
                SELECT DISTINCT t.id as numeroChamado, 
                t.name as titulo, 
                t.date as dataAbertura2,
                t.solvedate as solvedate2, 
                DATE_FORMAT(t.date, '%d/%m/%Y %H:%m:%s') as dataAbertura, 
                DATE_FORMAT(t.closedate, '%d/%m/%Y') as closedate, 
                t.solvedate, 
                DATE_FORMAT(t.date_mod, '%d/%m/%Y %H:%m:%s') as datemode, 
                CASE WHEN t.type = 1 THEN 'Incidente' WHEN t.type = 2 THEN 'Requisicao' END AS tipo, 
                CASE WHEN t.urgency = 1 THEN 'Muito Baixo' WHEN t.urgency = 2 THEN 'Baixa' 
                WHEN t.urgency = 3 THEN 'Media' 
                WHEN t.urgency = 4 THEN 'Alta' 
                WHEN t.urgency = 5 THEN 'Muito Alta' end as urgencia,
                CASE WHEN t.urgency = 1 THEN 'Muito Baixo' 
                WHEN t.urgency = 2 THEN 'Baixo' 
                WHEN t.urgency = 3 THEN 'Medio' 
                WHEN t.urgency = 4 THEN 'Alto'
                WHEN t.urgency = 5 THEN 'Muito Alto' end as impacto, 
                CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '2' AND t.is_deleted = 1 THEN 'Excluido'
                WHEN t.status = '3' AND t.is_deleted = 1 THEN 'Excluido' 
                WHEN t.status = '4' AND t.is_deleted = 1 THEN 'Excluido' 
                WHEN t.status = '5' AND t.is_deleted = 1 THEN 'Excluido' 
                WHEN t.status = '6' AND t.is_deleted = 1 THEN 'Excluido' 
                WHEN t.status = '1' AND t.is_deleted = 0 THEN 'Novo' 
                WHEN t.status = '2' AND t.is_deleted = 0 THEN 'Em atendimento (atribuido)' 
                WHEN t.status = '3' AND t.is_deleted = 0 THEN 'Em atendimento (planejado)' 
                WHEN t.status = '4' AND t.is_deleted = 0 THEN 'Pendente' 
                WHEN t.status = '5' AND t.is_deleted = 0 THEN 'Solucionado' 
                WHEN t.status = '6' AND t.is_deleted = 0 THEN 'Fechado' end as status, 
                CASE WHEN t.status = '1' AND t.is_deleted = 1 THEN 99 
                WHEN t.status = '2' AND t.is_deleted = 1 THEN 99 
                WHEN t.status = '3' AND t.is_deleted = 1 THEN 99 
                WHEN t.status = '4' AND t.is_deleted = 1 THEN 99 
                WHEN t.status = '5' AND t.is_deleted = 1 THEN 99 
                WHEN t.status = '6' AND t.is_deleted = 1 THEN 99 else t.status end as codStatus, 
                t.is_deleted as excluido, 
                (SELECT gu.name FROM glpi_tickets_users gtu 
                INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 1 
                WHERE gtu.tickets_id = t.id limit 1) as nomeUsuario, 
                (SELECT gu.name FROM glpi_tickets_users gtu
                INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 2 
                WHERE gtu.tickets_id = t.id limit 1) as tecnico, 
                (SELECT gu.name FROM glpi_tickets_users gtu 
                INNER JOIN glpi_users gu on gu.id = gtu.users_id and `type` = 3
                WHERE gtu.tickets_id = t.id limit 1) as observador, 
                cat.name as categoria FROM glpi_tickets t
                LEFT JOIN glpi_tickets_users gtu ON gtu.tickets_id = t.id 
                LEFT JOIN glpi_users u ON u.id = gtu.users_id and gtu.type = 1 
                LEFT JOIN glpi_users atend ON atend.id = gtu.users_id and gtu.type = 2 
                LEFT JOIN glpi_users observ ON observ.id = gtu.users_id and gtu.type = 3
                LEFT JOIN glpi_itilcategories cat ON cat.id = t.itilcategories_id 
                WHERE 1 = 1 
                $strWhereDatas
                $strWhere) AS QUERYA 
                GROUP BY status, codStatus";
                $query = $db_cli->query($SQL);
                return $query->result_array();
    }

    public function buscarIdTicket($nomeUsuario){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select("id");
        $db_cli->where('users_id_recipient',$nomeUsuario);
        $db_cli->order_by('id DESC'); 
        $this->db->limit(1);
        return $db_cli->get("glpi_tickets")->result_array();
    }

    public function listarCategorias(){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select("id, name, completename ");
        $db_cli->order_by('name'); 
        return $db_cli->get("glpi_itilcategories")->result_array();
    }

    public function criarTicket($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_tickets",$item);
        $insert_id = $db_cli->insert_id();
        return $insert_id;
    }

    public function criarLogTicket($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_logs",$item);
        return $db_cli->insert_id();
    }

    public function criarFollowups($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_itilfollowups",$item);
        return $db_cli->insert_id();
    }

    public function vincularUsuarioTicket($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_tickets_users",$item);
        return $db_cli->insert_id();
    }

    public function vincularArquivoFollowups($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_documents_items",$item);
        return $db_cli->insert_id();
    }

    public function criarRegistroArquivo($item){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->insert("glpi_documents_items",$item);
        return $db_cli->insert_id();
    }

    public function listaParamsBi($idusuario){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('usuario_powerbi, senha_powerbi ');   
        $db_cli->where('idusuario',$idusuario);
        return $db_cli->get("wtm_powerbi")->result_array();
    }

    public function listaDadosAdmin($idusuario){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('idusuario, usuario as useradmin');   
        $db_cli->where('idusuario',$idusuario);
        return $db_cli->get("wtm_usersadmin")->result_array();
    }

    public function listarUsuariosadmin(){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('id, idusuario, usuario, datacriacao');   
        $db_cli->order_by('datacriacao desc');
        return $db_cli->get("wtm_usersadmin")->result_array();
    }    

    public function listarUsuarioDash(){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('pb.id, e.name, pb.datacriacao, pb.urlpowerbi, pb.entidade');  
        $db_cli->join('glpi_entities e', 'e.id = pb.entidade', 'INNER');      
        $db_cli->order_by('pb.datacriacao desc');
        return $db_cli->get("wtm_powerbi pb")->result_array();
    }

    public function listarUsuarioDashGrafana(){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('g.id, e.name, e.id as entidade');  
        $db_cli->join('glpi_entities e', 'e.id = g.entidade', 'INNER');      
        $db_cli->order_by('e.name desc');
        return $db_cli->get("wtm_grafana g")->result_array();
    }

    public function listarUsuarioGrafana(){
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT 
                wg.id,
                e.name as usuario,
                e.id as entidade,
                wg.idusuario,
                wg.urlwindows,
                wg.urllinux,
                wg.urlswitches,
                wg.urlbackup,
                wg.urlvirtualizacao,
                wg.urlstorage,
                wg.urlaplicacao,
                wg.urlfirewall,
                wg.urlenergia,
                wg.urloffice365,
                wg.urlseguranca 
                FROM wtm_grafana wg
                INNER JOIN glpi_entities e on e.id = wg.idusuario
                ORDER BY gu.name";
         $query = $db_cli->query($SQL);
         return $query->result_array();
    }

    public function pegaUrlPowerBi($entidade){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('id, entidade, name, datacriacao, urlpowerbi');   
        $db_cli->where('entidade',$entidade);
        return $db_cli->get("wtm_powerbi")->result_array();
    }

    public function pegaUrlGrafana($usuario){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('id, 
                         urlwindows,
                         urllinux,
                         urlswitches,
                         urlbackup,
                         urlvirtualizacao,
                         urlstorage,
                         urlaplicacao,
                         urlfirewall,
                         urlenergia,
                         urloffice365,
                         urlseguranca,
                         urlplaylist');   
        $db_cli->where('entidade',$usuario);
        return $db_cli->get("wtm_grafana")->result_array();
    }

    public function listarUsuariosgeral(){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select("id, name, 
                         CASE WHEN profiles_id = 1 THEN 'Self-Service'
                              WHEN profiles_id = 2 THEN 'Observer'
                              WHEN profiles_id = 3 THEN 'Admin'
                              WHEN profiles_id = 4 THEN 'Super-Admin'
                              WHEN profiles_id = 5 THEN 'Hotliner'
                              WHEN profiles_id = 6 THEN 'Technician'
                              WHEN profiles_id = 7 THEN 'Supervisor' end as tipousuario
                        ");   
        $db_cli->where('is_deleted = 0');   
        $db_cli->where("profiles_id in ('1','2','3','4','5','6','7')");   
        $db_cli->order_by('name');
        return $db_cli->get("glpi_users")->result_array();
    }

    public function listarUsuariosgeral2(){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select("id, name, 
                         CASE WHEN profiles_id = 1 THEN 'Self-Service'
                              WHEN profiles_id = 2 THEN 'Observer'
                              WHEN profiles_id = 3 THEN 'Admin'
                              WHEN profiles_id = 4 THEN 'Super-Admin'
                              WHEN profiles_id = 5 THEN 'Hotliner'
                              WHEN profiles_id = 6 THEN 'Technician'
                              WHEN profiles_id = 7 THEN 'Supervisor'
                              WHEN profiles_id = 0 THEN '' end as tipousuario
                        ");   
        $db_cli->where('is_deleted = 0');   
        $db_cli->order_by('name');
        return $db_cli->get("glpi_users")->result_array();
    }

    public function detalheuserpowerbi($usuario){
        $db_cli = $this->load->database('default', TRUE);
        $db_cli->select('pb.id, e.name, pb.datacriacao, pb.urlpowerbi');  
        $db_cli->join('glpi_entities e', 'e.id = pb.entidade', 'INNER');  
        $db_cli->where('pb.entidade',$usuario);   
        return $db_cli->get("wtm_powerbi pb")->result_array();
    }

    public function alterarusuariopowerbi($idusuario,$urlpowerbi){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->set('urlpowerbi',$urlpowerbi);  
        $this->db->where('id',$idusuario);
        return $this->db->update('wtm_powerbi');  
    }

    public function finalizarChamado($numChamadoFinalizar){
        $db_cli = $this->load->database('default', TRUE);

        date_default_timezone_set('America/Sao_Paulo');
        $dataFinalizacao = date('Y-m-d H:i:s');

        $this->db->set('closedate',$dataFinalizacao);  
        $this->db->set('solvedate',$dataFinalizacao);  
        $this->db->set('status',6);  
        $this->db->where('id',$numChamadoFinalizar);
        return $this->db->update('glpi_tickets');  
    }
    
    public function detalheusergrafana($usuario){
        $db_cli = $this->load->database('default', TRUE);
        $SQL = "SELECT
                g.id, 
                g.entidade, 
                g.urlwindows, 
                g.urllinux, 
                g.urlswitches, 
                g.urlbackup, 
                g.urlvirtualizacao,
                g.urlstorage,
                g.urlaplicacao,
                g.urlfirewall,
                g.urlenergia,
                g.urloffice365,
                g.urlseguranca,
                g.urlplaylist,
                e.name as usuario
                FROM wtm_grafana g
                LEFT JOIN glpi_entities e ON e.id = g.entidade
                WHERE e.id = '$usuario' ";
                $query = $db_cli->query($SQL);
                return $query->result_array();
    }

    public function alterarusuariografana($idusuario,$urlwindows,$urllinux,$urlswitches,$urlbackup,$urlvirtualizacao,$urlstorage,$urlaplicacao,$urlfirewall,$urlenergia,$urloffice365,$urlseguranca,$urlplaylist){
        $db_cli = $this->load->database('default', TRUE);
        $this->db->set('urlwindows',$urlwindows);  
        $this->db->set('urllinux',$urllinux);  
        $this->db->set('urlswitches',$urlswitches);  
        $this->db->set('urlbackup',$urlbackup);  
        $this->db->set('urlvirtualizacao',$urlvirtualizacao);  
        $this->db->set('urlstorage',$urlstorage);  
        $this->db->set('urlaplicacao',$urlaplicacao);  
        $this->db->set('urlfirewall',$urlfirewall);  
        $this->db->set('urlenergia',$urlenergia);  
        $this->db->set('urloffice365',$urloffice365);  
        $this->db->set('urlseguranca',$urlseguranca);  
        $this->db->set('urlplaylist',$urlplaylist);  
        $this->db->where('entidade',$idusuario);
        return $this->db->update('wtm_grafana');  
    }

}

?>