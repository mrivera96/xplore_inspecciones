import { Component, OnInit } from '@angular/core';
import {InspectionsService} from "../../../services/inspections.service";
import {ActivatedRoute, Router} from "@angular/router";
import {Inspection} from "../../../interfaces/inspection";

@Component({
  selector: 'app-ver',
  templateUrl: './ver.component.html',
  styleUrls: ['./ver.component.css']
})
export class VerComponent implements OnInit {
  idInspeccion: number
  apiEndPoint: string
  inspeccion: Inspection
  loading = false;

  constructor(
    private inspeccionesService: InspectionsService,
    private route: ActivatedRoute,
    private router: Router
  ) {
    this.apiEndPoint = 'http://192.168.0.3:8069/inspApi/public'
  }

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

  irACerrar(){
    this.router.navigate(['close-inspeccion', this.idInspeccion])
  }
}
