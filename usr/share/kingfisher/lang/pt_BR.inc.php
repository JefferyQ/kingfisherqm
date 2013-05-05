<?php

class Lang {

    public $lang;

    function __construct() {

	$this->lang['main'] = 'Principal';
	$this->lang['tables'] = 'Tabelas'; 
	$this->lang['reports'] = 'Relatórios';
	$this->lang['graphics'] = 'Gráficos';
	$this->lang['settings'] = 'Configurações';
	$this->lang['help'] = 'Ajuda';
	$this->lang['logout'] = 'Sair';
	$this->lang['logged_as'] = 'Logado como';

	$this->lang['users'] = 'Usuários';
	$this->lang['sectors'] = 'Setores';
	$this->lang['costscenter'] = 'Centro de Custos';
	$this->lang['printers'] = 'Impressoras';
	$this->lang['paperformats'] = 'Formatos de Papel';

	$this->lang['list_all_jobs'] = 'Listar Todas As Impressões';
	$this->lang['search_jobs'] = 'Pesquisar Impressões';
	$this->lang['total_pages'] = 'Total De Páginas';
	$this->lang['total_pages_grouped'] = 'Total De Páginas Agrupado';

	$this->lang['top_10_users'] = 'Top 10 Usuários';
	$this->lang['top_10_printers'] = 'Top 10 Impressoras';
	$this->lang['top_10_paperformats'] = 'Top 10 Formatos De Papel';
	$this->lang['colormode'] = 'Modo de Cor';

	$this->lang['print_queue'] = 'Fila de Impressão';
	$this->lang['last_jobs'] = 'Últimas Impressões';
	$this->lang['about'] = 'Sobre';

	$this->lang['login'] = 'Usuário';
	$this->lang['password'] = 'Senha';
	$this->lang['send'] = 'Enviar';

	$this->lang['add_new_sector'] = 'Adicionar novo setor';
	$this->lang['delete_this_sector'] = 'Excluir este setor';
	$this->lang['new_sector_name'] = 'Nome do novo setor';

	$this->lang['add_new_costcenter'] = 'Adicionar novo centro de custo';
	$this->lang['delete_this_costcenter'] = 'Excluir este centro de custo';
	$this->lang['new_costcenter_name'] = 'Nome do novo centro de custo';

	$this->lang['date'] = 'Data';
	$this->lang['time'] = 'Hora';
	$this->lang['user'] = 'Usuário';
	$this->lang['title'] = 'Título';
	$this->lang['printer'] = 'Impressora';
	$this->lang['paperformat'] = 'Formato de Papel';
	$this->lang['status'] = 'Situação';
	$this->lang['job_size'] = 'Tamanho';
	$this->lang['copies'] = 'Cópias';
	$this->lang['number_of_pages'] = 'N&#176; De Páginas';
	$this->lang['total_pages'] = 'Total De Páginas';

	$this->lang['user_settings'] = 'Configurações do Usuário';
	$this->lang['sector'] = 'Setor';
	$this->lang['costcenter'] = 'Centro De Custo';
	$this->lang['jobs_in_default_sector'] = 'Impressões no setor default';
	$this->lang['jobs_in_default_costcenter'] = 'Impressões no centro de custo default';
	$this->lang['total_price'] = 'Preço Total';
	$this->lang['alter_to_sector'] = 'Alterar para o setor';
	$this->lang['alter_to_costcenter'] = 'Alterar para o centro de custo';

	$this->lang['begin'] = 'Início';
	$this->lang['end'] = 'Fim';
	$this->lang['year'] = 'Ano';
	$this->lang['month'] = 'Mês';
	$this->lang['day'] = 'Dia';
	$this->lang['search'] = 'Pesquisar';

	$this->lang['page_price'] = 'Preço da Página';
	$this->lang['add_page_price'] = 'Adicionar ao Preço da Página';
	$this->lang['price_gray'] = 'Preço (Preto e Branco)';
	$this->lang['price_color'] = 'Preço (Colorida)';

	$this->lang['queue_paused'] = 'Fila Pausada';

	$this->lang['language'] = 'Idioma';

    }

}

?>
