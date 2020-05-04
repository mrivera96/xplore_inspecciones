import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';

import {Usuario} from '../../interfaces/usuario';
import {UsuariosService} from '../../services/usuarios.service';
import {AuthenticationService} from '../../services/authentication.service';
import { InspeccionesService } from "../../services/inspecciones.service";
import {Inspeccion} from "../../interfaces/inspeccion";

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  loading = false;
  inspecciones: Inspeccion[];

  constructor(
    private inspeccionesService: InspeccionesService) { }

  ngOnInit(): void {
    this.loading = true;
    this.inspeccionesService.getInspecciones().subscribe( response => {
      this.inspecciones = response.data;
      this.loading = false;
    });
  }


}
