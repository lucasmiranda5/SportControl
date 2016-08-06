<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Painel do Professor
Route::get('/', ['as' => 'dashboard','middleware' => 'auth.user',function () {
    return view('professor.home');
}]);
Route::get('/login',function(){
	return view('professor.login');
});
Route::post('/login','Professor\ControllerLogin@login');
Route::group(['as' => 'professor::'], function () {
	Route::get('/modalidades',['as' => 'modalidade','uses' => 'Professor\ControllerModalidades@listar']);
	Route::get('/modalidades/chamar/{id?}',['as' => 'modalidade::listar','uses' => 'Professor\ControllerModalidades@modalidades']);
	#Atletas
	Route::group(['as' => 'atletas::','prefix' => 'atletas'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Professor\ControllerAtletas@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Professor\ControllerAtletas@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Professor\ControllerAtletas@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Professor\ControllerAtletas@excluir']);
	});

	#Equipes
	Route::group(['as' => 'equipes::','prefix' => 'equipes'], function () {
		Route::match(array('GET', 'POST'),'/',['as' => 'formulario','uses' => 'Professor\ControllerAtletasModalidade@formulario']);
		Route::post('/modalidades', ['as' => 'modalidades','uses' => 'Professor\ControllerAtletasModalidade@modalidades']);
		Route::post('/chamarAtletas', ['as' => 'chamarAtletas','uses' => 'Professor\ControllerAtletasModalidade@chamarAtletas']);
	});
});


//Painel Administrador
Route::get('/painel', ['as' => 'dashboard','middleware' => 'auth.admin',function () {
    return view('admin.home');
}]);
Route::get('/painel/login',function(){
	return view('admin/login');
});
Route::post('/painel/login','Admin\ControllerLogin@login');
Route::group(['as' => 'admin::','prefix' => 'painel'], function () {
	#Instituição
	Route::group(['as' => 'instituicao::','prefix' => 'instituicao'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerInstituicao@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerInstituicao@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerInstituicao@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerInstituicao@excluir']);
	});

	#Campus
	Route::group(['as' => 'campus::','prefix' => 'campus'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerCampus@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerCampus@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerCampus@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerCampus@excluir']);
	});

	#Usuarios
	Route::group(['as' => 'usuarios::','prefix' => 'usuarios'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerUsuario@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerUsuario@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerUsuario@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerUsuario@excluir']);
		Route::get('/campus/{id?}', ['as' => 'campus','uses' => 'Admin\ControllerUsuario@campus']);
	});

	#Categoria Modaliddades
	Route::group(['as' => 'categoriamodalidade::','prefix' => 'categoriamodalidade'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerCategoriaModalidade@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerCategoriaModalidade@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerCategoriaModalidade@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerCategoriaModalidade@excluir']);
	});

	#Modaliddades
	Route::group(['as' => 'modalidades::','prefix' => 'modalidades'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerModalidade@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerModalidade@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerModalidade@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerModalidade@excluir']);
	});

	#Eventos
	Route::group(['as' => 'eventos::','prefix' => 'eventos'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerEventos@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerEventos@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerEventos@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerEventos@excluir']);
		Route::group(['as' => 'modalidades::','prefix' => 'modalidades'], function () {
			Route::get('/{id}',['as' => 'listar','uses' => 'Admin\ControllerEventos@listarModalidade']);
			Route::match(array('GET', 'POST'),'/novo/{id}', ['as' => 'novo','uses' => 'Admin\ControllerEventos@novoModalidade']);
			Route::match(array('GET', 'POST'),'/editar/{evento}/{id}', ['as' => 'editar','uses' => 'Admin\ControllerEventos@editarModalidade']);
			Route::get('/excluir/{evento}/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerEventos@excluirModalidade']);
		});
		Route::match(array('GET', 'POST'),'/participantes/{id}', ['as' => 'participantes','uses' => 'Admin\ControllerEventos@participantes']);
		Route::match(array('GET', 'POST'),'/participantes/modalidade/{evento}/{campus?}', ['as' => 'modalidade','uses' => 'Admin\ControllerEventos@gerarModalidades']);

	});

	#Atletas
	Route::group(['as' => 'atletas::','prefix' => 'atletas'], function () {
		Route::get('/',['as' => 'listar','uses' => 'Admin\ControllerAtletas@listar']);
		Route::match(array('GET', 'POST'),'/novo', ['as' => 'novo','uses' => 'Admin\ControllerAtletas@novo']);
		Route::match(array('GET', 'POST'),'/editar/{id}', ['as' => 'editar','uses' => 'Admin\ControllerAtletas@editar']);
		Route::get('/excluir/{id}', ['as' => 'excluir','uses' => 'Admin\ControllerAtletas@excluir']);
	});

	#Equipes
	Route::group(['as' => 'equipes::','prefix' => 'equipes'], function () {
		Route::match(array('GET', 'POST'),'/',['as' => 'formulario','uses' => 'Admin\ControllerAtletasModalidade@formulario']);
		Route::post('/modalidades', ['as' => 'modalidades','uses' => 'Admin\ControllerAtletasModalidade@modalidades']);
		Route::post('/chamarAtletas', ['as' => 'chamarAtletas','uses' => 'Admin\ControllerAtletasModalidade@chamarAtletas']);
	});

	#Fichas de inscriçao
	Route::group(['as' => 'fichas::','prefix' => 'fichas'], function () {
		Route::match(array('GET', 'POST'),'/',['as' => 'index','uses' => 'Admin\ControllerFichas@index']);
		Route::post('/gerar', ['as' => 'gerar','uses' => 'Admin\ControllerFichas@gerar']);

	});
});
