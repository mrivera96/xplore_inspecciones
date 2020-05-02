import {
  AfterViewInit,
  Component,
  ElementRef,
  EventEmitter,
  Input,
  OnInit,
  Output,
  ViewChild,
  ViewChildren
} from '@angular/core';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AuthenticationService } from '../../../services/authentication.service';
import { VehiculosService } from "../../../services/vehiculos.service";
import { Vehiculo} from "../../../interfaces/vehiculo";
import { MatTabGroup } from "@angular/material/tabs";
import { AgenciasService } from "../../../services/agencias.service";
import { Agencia } from "../../../interfaces/agencia";
import { Tanque } from "../../../interfaces/tanque";
import {Accesorio} from "../../../interfaces/accesorio";
import {fromEvent} from "rxjs";
import {pairwise, switchMap, takeUntil} from "rxjs/operators";


@Component({
  selector: 'app-crear',
  templateUrl: './crear.component.html',
  styleUrls: ['./crear.component.css']
})
export class CrearComponent implements OnInit, AfterViewInit {
  inspeccionForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;
  error = '';
  tanqueCombValue = 9;
  private cx: CanvasRenderingContext2D;
  private cxFirma: CanvasRenderingContext2D;
  filterVehiculoResults: Vehiculo[] = [];
  tiposVehiculos: [] = [];
  tiposKilom: [{ v: string; k: string }, { v: string; k: string }] = [{
    k: 'Kilometros',
    v: 'K'
  }, {
    k: 'Millas',
    v: 'M'
  }];
  agencias: Agencia[];
  tanquesCombustible: Tanque[];
  @ViewChild(MatTabGroup) matTabs: MatTabGroup;
  fechaActual: Date = new Date();
  horaActual: string = this.fechaActual.getHours() + ':' + this.fechaActual.getMinutes();
  accesorios: Accesorio[];
  @ViewChild("canvasDanios") public canvasDanios: ElementRef;
  @ViewChild("canvasFirma") public canvasFirma: ElementRef;
  @Input() public width = 900;
  @Input() public height = 650;
  shape = 0;

  constructor(private formBuilder: FormBuilder,
              private route: ActivatedRoute,
              private router: Router,
              private authenticationService: AuthenticationService,
              private vehiculoService: VehiculosService,
              private agenciasService: AgenciasService) {
    this.vehiculoService.getTiposVehiculos().subscribe( response => {
      this.tiposVehiculos = response.data;
    });
  }

  // getter para fácil acceso a los campos del formulario
  get f() { return this.inspeccionForm.controls; }

  ngOnInit(): void {
    this.inspeccionForm = this.formBuilder.group({
      datosGenerales : this.formBuilder.group({
        nVehiculo: ['', Validators.required],
        nPlaca: ['', Validators.required],
        marcaVeh: ['', Validators.required],
        modeloVeh: ['', Validators.required],
        tipoVehiculo: ['', Validators.required],
        colorVeh: ['', Validators.required],
        tipoKilom: ['', Validators.required],
        tipoComb: ['', Validators.required],
      }),
      datosSalida: this.formBuilder.group({
        idAgenciaSalida: ['', Validators.required],
        combSalida: ['', Validators.required],
        rendCombSalida: ['', Validators.required],
        odoSalida: ['', Validators.required],
        fechaSalida: ['', Validators.required],
        horaSalida: ['', Validators.required]
      }),
      accesorios: this.formBuilder.group({
        Alfombras: [0],
        Permiso: [0],
        Antena: [0],
        Gata: [0],
        'Tapon de Gasolina': [0],
        Maneral: [0],
        Extintor: [0],
        Llaves: [0],
        'Llanta de Repuesto': [0],
        Destornillador: [0],
        Tenazas: [0],
        Triangulo: [0],
        'Llave de Rueda': [0],
      }),
      obsSalida: [''],

      firma: this.formBuilder.group({
        nomRecibeVehiculo: ['', Validators.required],
        firmaClienteSalida: ['', Validators.required]
      })
    });


    this.cargarDatos();

    this.f.datosSalida.get('fechaSalida').setValue(this.fechaActual);
    this.f.datosSalida.get('horaSalida').setValue(this.horaActual);
  }

  ngAfterViewInit() {
    this.initCanvasDanios();
    this.initCanvasFirma();
  }

  initCanvasDanios() {
    const canvasEl: HTMLCanvasElement = this.canvasDanios.nativeElement;
    this.cx = canvasEl.getContext('2d');

    canvasEl.width = this.width;
    canvasEl.height = this.height;

    this.cx.lineWidth = 3;
    this.cx.lineCap = 'round';
    this.cx.strokeStyle = '#000';

    this.dibujarImagen();
    this.captureEvents(canvasEl);
  }

  initCanvasFirma() {
    const canvasElFirma: HTMLCanvasElement = this.canvasFirma.nativeElement;
    this.cxFirma = canvasElFirma.getContext('2d');

    canvasElFirma.width = this.width / 3;
    canvasElFirma.height = this.height / 5;

    this.cxFirma.lineWidth = 3;
    this.cxFirma.lineCap = 'round';
    this.cxFirma.strokeStyle = '#000';
    this.captureEvents(canvasElFirma);
  }


  dibujarImagen() {
    const baseImage = new Image();
    baseImage.src = '../assets/img/car-line-draw.png';

    baseImage.onload = () => {
      this.cx.drawImage(baseImage, 0, 0, 900, 650);
    };
  }

  cargarDatos() {
    this.f.datosGenerales.get('nVehiculo').valueChanges.subscribe( filter => {
      this.vehiculoService.searchVehiculo(filter).subscribe( response => {
        this.filterVehiculoResults = response.data;
      });
    });

    this.agenciasService.getAgencias().subscribe( response => {
      this.agencias = response.data;
    });

    this.vehiculoService.getTanquesComb().subscribe( response => {
      this.tanquesCombustible = response.data;
    });

    this.vehiculoService.getAccesorios().subscribe( response => {
      this.accesorios = response.data;
    });
  }

  getVehiculoData() {
    if (this.f.datosGenerales.get('nVehiculo').value !== '') {
    const nVehiculo = this.f.datosGenerales.get('nVehiculo').value;
    this.vehiculoService.getVehiculoData(nVehiculo).subscribe( response => {
      const vehiculo: Vehiculo = response.data;
      this.llenarCampos(
          vehiculo.modelo.marca.descMarca,
          vehiculo.modelo.nomModelo,
          vehiculo.color,
          vehiculo.tipoKilometraje,
          vehiculo.combustible.descTipoComb,
        vehiculo.placa
        );
      const tVField = document.getElementById('tipoVehiculo');
      tVField.focus();
      });
    }
  }

  llenarCampos( marca, modelo, color, tipoKilom, tipoComb, placa) {
    this.f.datosGenerales.get('marcaVeh').setValue(marca);
    this.f.datosGenerales.get('modeloVeh').setValue(modelo);
    this.f.datosGenerales.get('colorVeh').setValue(color);
    this.f.datosGenerales.get('tipoKilom').setValue(tipoKilom);
    this.f.datosGenerales.get('tipoComb').setValue(tipoComb);
    this.f.datosGenerales.get('nPlaca').setValue(placa);
  }

  avanzarTab() {
      switch (this.matTabs.selectedIndex) {
        case 0: {
          if (!this.inspeccionForm.get('datosGenerales').valid) {
            const invalidFields = [].slice.call(document.getElementsByClassName('ng-invalid'));
            invalidFields[1].focus();
          } else {
            this.matTabs.selectedIndex = this.matTabs.selectedIndex + 1;
          }
          break;
        }
        case 1: {
          if (!this.inspeccionForm.get('datosSalida').valid) {
            const invalidFields = [].slice.call(document.getElementsByClassName('ng-invalid'));
            invalidFields[1].focus();
          } else {
            this.matTabs.selectedIndex = this.matTabs.selectedIndex + 1;
          }
          break;
        }

        default: {
          this.matTabs.selectedIndex = this.matTabs.selectedIndex + 1;
          break;
        }

      }

  }

  formatLabel(value: number | null) {
    switch (value) {
      case 0: {
        return 'E';
        break;
      }
      case 8: {
        return 'F';
        break;
      }
      case 9: {
        return 'F+';
        break;
      }
      default: {
        return value + '/8';
      }

    }
  }


  private captureEvents(canvasEl: HTMLCanvasElement) {
    // this will capture all mousedown events from the canvas element
    fromEvent(canvasEl, 'mousedown')
      .pipe(
        switchMap((e) => {
          // after a mouse down, we'll record all mouse moves
          return fromEvent(canvasEl, 'mousemove')
            .pipe(
              // we'll stop (and unsubscribe) once the user releases the mouse
              // this will trigger a 'mouseup' event
              takeUntil(fromEvent(canvasEl, 'mouseup')),
              // we'll also stop (and unsubscribe) once the mouse leaves the canvas (mouseleave event)
              takeUntil(fromEvent(canvasEl, 'mouseleave')),
              // pairwise lets us get the previous value to draw a line from
              // the previous point to the current point
              pairwise()
            );
        })
      )
      .subscribe((res: [MouseEvent, MouseEvent]) => {
        const rect = canvasEl.getBoundingClientRect();

        // previous and current position with the offset
        const prevPos = {
          x: res[0].clientX - rect.left,
          y: res[0].clientY - rect.top
        };

        const currentPos = {
          x: res[1].clientX - rect.left,
          y: res[1].clientY - rect.top
        };

        // this method we'll implement soon to do the actual drawing
        this.drawOnCanvas(prevPos, currentPos);
      });
  }

  private drawOnCanvas( prevPos: { x: number, y: number }, currentPos: { x: number, y: number }) {
    switch (this.matTabs.selectedIndex) {
      case 3: {

        if (!this.cx) { return; }

        switch (this.shape) {
          case "1": {
            this.cx.strokeRect(currentPos.x, currentPos.y, 20, 20);
            break;
          }
          case "2": {
            this.cx.beginPath();
            this.cx.arc(currentPos.x, currentPos.y, 11, 0, 2 * Math.PI);
            this.cx.stroke();
            this.cx.closePath();
            break;
          }
          case "3": {
            const height = 20 * (Math.sqrt(3) / 2);

            this.cx.beginPath();
            this.cx.moveTo(currentPos.x, currentPos.y);
            this.cx.lineTo(currentPos.x + 10, currentPos.y + height);
            this.cx.lineTo(currentPos.x - 10, currentPos.y + height );

            this.cx.closePath();
            this.cx.stroke();
            break;
          }
          case "4": {
            break;
          }
          default: {
            this.cx.beginPath();
            if (prevPos) {
              this.cx.moveTo(prevPos.x, prevPos.y); // from
              this.cx.lineTo(currentPos.x, currentPos.y);
              this.cx.stroke();
            }
          }

        }
        break;
      }
      case 5: {
        if (!this.cxFirma) { return; }

        this.cxFirma.beginPath();
        this.cx.bezierCurveTo(prevPos.x, prevPos.y, currentPos.x, currentPos.y, currentPos.x, currentPos.y);

        if (prevPos) {
          this.cxFirma.moveTo(prevPos.x, prevPos.y); // from
          this.cxFirma.lineTo(currentPos.x, currentPos.y);
          this.cxFirma.stroke();
        }
        break;
      }

    }

  }

  limpiarCanvas() {
    switch (this.matTabs.selectedIndex) {
      case 3: {
        this.cx.clearRect(0, 0, this.width, this.height);
        this.dibujarImagen();
        break;
      }
      case 5: {
        this.cxFirma.clearRect(0, 0, this.width, this.height);
        break;
      }

    }

  }

  limpiarForm() {
    this.inspeccionForm.reset();
    this.matTabs.selectedIndex = 0;
  }

  onFormSubmit() {
    if (this.inspeccionForm.valid) {
      console.log(this.inspeccionForm);
    }

  }

}
