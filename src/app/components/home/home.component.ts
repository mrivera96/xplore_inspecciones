import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';

import {Usuario} from '../../interfaces/usuario';
import {UsuariosService} from '../../services/usuarios.service';
import {AuthenticationService} from '../../services/authentication.service';
import { InspeccionesService } from "../../services/inspecciones.service";
import {Inspeccion} from "../../interfaces/inspeccion";
import { Router } from '@angular/router';
import {formatDate} from "@angular/common";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  loading = false;
  inspecciones: Inspeccion[];
  displayedColumns = [
    'Nº de Inspección',
    'Vehículo',
    'Fecha de creación',
    'Acción'
  ]

  constructor(
    private inspeccionesService: InspeccionesService,
    private router: Router) { }

  ngOnInit(): void {
    this.loading = true
    this.inspeccionesService.getInspecciones().subscribe( response => {
      this.inspecciones = response.data
      this.inspecciones.forEach(inspection => {
        inspection.fechaProceso = new Date(inspection.fechaProceso).toLocaleString()//formatDate(inspection.fechaProceso,'d/m/yyy h:m','es')
      })
      this.loading = false
    })
  }

  verInspeccion(id){
    this.router.navigate(['ver-inspeccion',id])
  }

  cerrarInspeccion(id){
    this.router.navigate(['cerrar-inspeccion',id])
  }


}
