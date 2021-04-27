import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {HomeComponent} from './components/home/home.component';
import {AuthGuard} from './helpers/auth.guard';
import {LoginComponent} from './components/login/login.component';
import {CrearComponent} from './components/inspections/create/crear.component';
import {VerComponent} from "./components/inspections/detail/ver.component";
import {CerrarComponent} from "./components/inspections/close/cerrar.component";


const routes: Routes = [
  { path: '', component: HomeComponent, canActivate: [AuthGuard] },
  { path: 'login', component: LoginComponent },
  { path: 'create-inspeccion', component: CrearComponent, canActivate: [AuthGuard] },
  { path: 'detail-inspeccion/:idInspeccion', component: VerComponent, canActivate: [AuthGuard] },
  { path: 'close-inspeccion/:idInspeccion', component: CerrarComponent, canActivate: [AuthGuard] },

  // redirige a home si no existe la ruta

  { path: '**', redirectTo: '' }
];

@NgModule({
  imports: [RouterModule.forRoot(routes)],
  exports: [RouterModule]
})
export class AppRoutingModule { }
