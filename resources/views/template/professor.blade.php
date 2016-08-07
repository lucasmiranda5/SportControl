@extends('template.header')
@section('conteudo_geral')
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">Menu</li>
             <li>
              <a href="">
                <i class="fa fa-dashboard"></i> <span>Início</span>
              </a>
              </li>
              <li>
              <a href="{{route('professor::modalidade')}}">
                <i class="fa fa-dashboard"></i> <span>Modalidades</span>
              </a>
              </li>
               <li>
              <a href="{{route('professor::atletas::listar')}}">
                <i class="fa fa-dashboard"></i> <span>Atletas</span>
              </a>
              </li>
               <li>
              <a href="{{route('professor::equipes::formulario')}}">
                <i class="fa fa-dashboard"></i> <span>Equipes</span>
              </a>
              </li>
                <li>
               <a href="{{route('professor::fichas::index')}}">
                <i class="fa fa-dashboard"></i> <span>Fichas de inscrição</span>
              </a>
            </li>
             
             <li >
              <a href="">
                <i class="glyphicon glyphicon-log-out "></i> <span>Sair</span>
              </a>
            </li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
     <div class="content-wrapper">
     <div class="overlay" >

        @yield('conteudo')
     </div>
     </div>
      </div>
@endsection
   
