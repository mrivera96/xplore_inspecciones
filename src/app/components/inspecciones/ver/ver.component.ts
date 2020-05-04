import { Component, OnInit } from '@angular/core';
import {InspeccionesService} from "../../../services/inspecciones.service";
import {ActivatedRoute} from "@angular/router";
import {Inspeccion} from "../../../interfaces/inspeccion";

@Component({
  selector: 'app-ver',
  templateUrl: './ver.component.html',
  styleUrls: ['./ver.component.css']
})
export class VerComponent implements OnInit {
  idInspeccion: number;

  inspeccion: Inspeccion;
  loading = false;

  constructor(
    private inspeccionesService: InspeccionesService,
    private route: ActivatedRoute,
  ) { }

  ngOnInit(): void {
    this.loading = true
    this.route.paramMap.subscribe(params => {
      this.idInspeccion =  Number(params.get("idInspeccion"));
    });

    this.inspeccionesService.getInspeccionById(this.idInspeccion).subscribe(response => {
      this.inspeccion = response.data;
      this.loading = false;
    });
  }

  formatLabel(value) {
    switch (value) {
      case "0": {
        return 'E';
        break;
      }
      case "8": {
        return 'F';
        break;
      }
      case "9": {
        return 'F+';
        break;
      }
      default: {
        return value + '/8';
      }

    }
  }
  imprimirHoja(){
    window.print();
  }
}
