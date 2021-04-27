import {AfterViewInit, Component, ElementRef, Input, OnInit, ViewChild} from '@angular/core';
import {ActivatedRoute, Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CarsService} from "../../../services/cars.service";
import {AgenciesService} from "../../../services/agencies.service";
import {Agency} from "../../../interfaces/agency";
import {Tank} from "../../../interfaces/tank";
import {formatDate} from "@angular/common";
import {fromEvent} from "rxjs";
import {pairwise, switchMap, takeUntil} from "rxjs/operators";
import { InspectionsService } from 'src/app/services/inspections.service';
@Component({
  selector: 'app-cerrar',
  templateUrl: './cerrar.component.html',
  styleUrls: ['./cerrar.component.css']
})
export class CerrarComponent implements OnInit, AfterViewInit {
  idInspeccion: number;
  inspeccionForm: FormGroup;
  agencias: Agency[];
  tanquesCombustible: Tank[];
  fechaActual;
  horaActual;
  @ViewChild("canvasFirma") public canvasFirma: ElementRef;
  @ViewChild("blankCanvas") public blankCanvas: ElementRef;
  private cxFirma: CanvasRenderingContext2D;
  @Input() public width = 900;
  @Input() public height = 650;
  loading = false

  tanqueCombValue = 9;
  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private vehiculoService: CarsService,
    private agenciasService: AgenciesService,
    private inspeccionesService: InspectionsService,
    private router: Router
    ) { }

  ngOnInit(): void {
    this.fechaActual  = new Date();
    this.inspeccionForm = this.formBuilder.group({
      idAgenciaEntrega: ['', Validators.required],
      combEntrega: [9, Validators.required],
      rendCombEntrega:  ['', Validators.required],
      odoEntrega: ['', Validators.required],
      fechaEntrega: [formatDate(this.fechaActual, 'yyyy-MM-dd', 'en'), Validators.required],
      horaEntrega: [formatDate(this.fechaActual, 'hh:mm', 'en'), Validators.required],
      firmaClienteEntrega: [''],
      nomEntregaVehiculo: ['', Validators.required]
    });
    this.cargarDatos();

  }

  cargarDatos() {
    this.route.paramMap.subscribe(params => {
      this.idInspeccion =  Number(params.get("idInspeccion"));
    });

    this.agenciasService.getAgencias().subscribe(response => {
      this.agencias = response.data;
    });

    this.vehiculoService.getTanquesComb().subscribe(response => {
      this.tanquesCombustible = response.data;
    });

  }

  ngAfterViewInit() {
    this.initCanvasFirma();
  }


  initCanvasFirma() {
    const canvasElFirma: HTMLCanvasElement = this.canvasFirma?.nativeElement;
    this.cxFirma = canvasElFirma.getContext('2d');

    canvasElFirma.width = this.width / 3;
    canvasElFirma.height = this.height / 5;

    this.cxFirma.lineWidth = 3;
    this.cxFirma.lineCap = 'round';
    this.cxFirma.strokeStyle = '#000';
    this.captureEvents(canvasElFirma);
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

  onFormSubmit()  {
    const canvasElFirma: HTMLCanvasElement = this.canvasFirma.nativeElement;
    const blankCanvas: HTMLCanvasElement = this.blankCanvas.nativeElement;
    const cFirmData = canvasElFirma.toDataURL();
    const bData = blankCanvas.toDataURL();
    if (cFirmData == bData) {
      this.inspeccionForm.get('firmaClienteentrega').setValue(canvasElFirma.toDataURL("image/png"));
    }

    if (this.inspeccionForm.valid) {
      this.loading = true;
      this.inspeccionesService.cerrarInspeccion(this.inspeccionForm.value, this.idInspeccion).subscribe(response => {
        if(response.error == 0){
          this.loading = false;
          this.router.navigate(['detail-inspeccion', response.data]);
        }
      });
    }

  }
  limpiarForm() {
    this.inspeccionForm.reset();
  }
  limpiarCanvas() {
    this.cxFirma.clearRect(0, 0, this.width, this.height);
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

  private drawOnCanvas(prevPos: { x: number, y: number }, currentPos: { x: number, y: number }) {


    if (!this.cxFirma) {
      return;
    }

    this.cxFirma.beginPath();
    this.cxFirma.bezierCurveTo(prevPos.x, prevPos.y, currentPos.x, currentPos.y, currentPos.x, currentPos.y);

    if (prevPos) {
      this.cxFirma.moveTo(prevPos.x, prevPos.y); // from
      this.cxFirma.lineTo(currentPos.x, currentPos.y);
      this.cxFirma.stroke();
    }


  }

}
