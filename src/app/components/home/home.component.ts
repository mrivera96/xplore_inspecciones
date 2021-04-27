import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';

import {User} from '../../interfaces/user';
import {UsersService} from '../../services/users.service';
import {AuthenticationService} from '../../services/authentication.service';
import { InspectionsService } from "../../services/inspections.service";
import {Inspection} from "../../interfaces/inspection";
import { Router } from '@angular/router';
import {formatDate} from "@angular/common";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  loading = false;
  inspecciones: Inspection[];
  displayedColumns = [
    'Nº de Inspección',
    'Vehículo',
    'Fecha de creación',
    'Acción'
  ]

  constructor(
    private inspeccionesService: InspectionsService,
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
    this.router.navigate(['detail-inspeccion',id])
  }

  cerrarInspeccion(id){
    this.router.navigate(['close-inspeccion',id])
  }


}
