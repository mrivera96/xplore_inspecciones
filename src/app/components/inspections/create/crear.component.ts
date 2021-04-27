import {
  AfterViewInit,
  Component,
  ElementRef,
  Input,
  OnInit,
  ViewChild,
} from '@angular/core'
import {FormBuilder, FormGroup, Validators} from '@angular/forms'
import {ActivatedRoute, Router} from '@angular/router'
import {AuthenticationService} from '../../../services/authentication.service'
import {CarsService} from "../../../services/cars.service"
import {Car} from "../../../interfaces/car"
import {MatTabGroup} from "@angular/material/tabs"
import {AgenciesService} from "../../../services/agencies.service"
import {Agency} from "../../../interfaces/agency"
import {Tank} from "../../../interfaces/tank"
import {Accesory} from "../../../interfaces/accesory"
import {CarType} from "../../../interfaces/car-type"
import {InspectionsService} from "../../../services/inspections.service"
import {formatDate} from "@angular/common"
import SignaturePad from "signature_pad";
import {MatDialog} from "@angular/material/dialog";
import {ResumeDialogComponent} from "../resume-dialog/resume-dialog.component";
import {ConfirmDialogComponent} from "./confirm-dialog/confirm-dialog.component";


@Component({
  selector: 'app-crear',
  templateUrl: './crear.component.html',
  styleUrls: ['./crear.component.css']
})
export class CrearComponent implements OnInit, AfterViewInit {
  inspeccionForm: FormGroup
  loading = false
  error = ''
  private cxFirma: CanvasRenderingContext2D
  filterVehiculoResults: Car[] = []
  tiposVehiculos: CarType[] = []
  tiposKilom: [{ v: string; k: string }, { v: string; k: string }] = [{
    k: 'Kilometros',
    v: 'K'
  }, {
    k: 'Millas',
    v: 'M'
  }]
  agencies: Agency[]
  tanquesCombustible: Tank[]
  @ViewChild(MatTabGroup) matTabs: MatTabGroup
  @ViewChild('damages') damagePadElement : ElementRef
  damagePad: any
  fechaActual: Date
  horaActual: string
  accesorios: Accesory[]

  @ViewChild("canvasFirma") public firmaPadElement: ElementRef
  firmaPad: any
  @ViewChild("blankCanvas") public blankCanvas: ElementRef
  @Input() public width = 900
  @Input() public height = 650

  existeInspeccion = false
  errInsp = ''

  constructor(private formBuilder: FormBuilder,
              private route: ActivatedRoute,
              private router: Router,
              private authenticationService: AuthenticationService,
              private vehiculoService: CarsService,
              private agenciasService: AgenciesService,
              private inspeccionesService: InspectionsService,
              public dialog: MatDialog
  ) {

    this.cargarDatos()

  }

  // getter para fácil acceso a los campos del formulario
  get f() {
    return this.inspeccionForm.controls
  }

  ngOnInit(): void {
    this.inspeccionForm = this.formBuilder.group({
      datosGenerales: this.formBuilder.group({
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
        combSalida: [9, Validators.required],
        rendCombSalida: ['', Validators.required],
        odoSalida: ['', Validators.required],
        fechaSalida: [formatDate(this.fechaActual, 'yyyy-MM-dd', 'en'), Validators.required],
        horaSalida: [formatDate(this.fechaActual, 'hh:mm', 'en'), Validators.required]
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
      firma: this.formBuilder.group({
        nomRecibeVehiculo: ['', Validators.required],
        firmaClienteSalida: ['']
      }),
      danios:['']
    })

    this.f.datosGenerales.get('nVehiculo').valueChanges.subscribe(filter => {
      this.vehiculoService.searchVehiculo(filter).subscribe(response => {
        this.filterVehiculoResults = response.data
      })
    })

  }

  ngAfterViewInit() {
    this.damagePad = new SignaturePad(this.damagePadElement?.nativeElement)
    this.firmaPad = new SignaturePad(this.firmaPadElement?.nativeElement)
    this.drawCarLine()
  }

  cargarDatos() {
    this.fechaActual = new Date()
    this.horaActual = this.fechaActual.getHours() + ':' + this.fechaActual.getMinutes()

    this.vehiculoService.getTiposVehiculos().subscribe(response => {
      this.tiposVehiculos = response.data
    })

    this.vehiculoService.getTanquesComb().subscribe(response => {
      this.tanquesCombustible = response.data
    })

    this.agenciasService.getAgencias().subscribe(response => {
      this.agencies = response.data
    })

    this.vehiculoService.getAccesorios().subscribe(response => {
      this.accesorios = response.data
    })
  }

  getVehiculoData() {
    if (this.f.datosGenerales.get('nVehiculo').value !== '') {
      const nVehiculo = this.f.datosGenerales.get('nVehiculo').value
      this.vehiculoService.getVehiculoData(nVehiculo).subscribe(response => {

        if (response.error == 1) {
          this.existeInspeccion = true
          this.errInsp = response.message
        } else {
          this.existeInspeccion = false
          const vehiculo: Car = response.data
          this.llenarCampos(
            vehiculo.marca,
            vehiculo.modelo,
            vehiculo.color,
            vehiculo.tipoVehiculo,
            vehiculo.tipoKilometraje,
            vehiculo.combustible,
            vehiculo.placa
          )
        }

      })
    }

  }

  llenarCampos(marca, modelo, color, tipoVehiculo, tipoKilom, tipoComb, placa) {
    this.f.datosGenerales.get('marcaVeh').setValue(marca)
    this.f.datosGenerales.get('modeloVeh').setValue(modelo)
    this.f.datosGenerales.get('colorVeh').setValue(color)
    this.f.datosGenerales.get('tipoVehiculo').setValue(tipoVehiculo)
    this.f.datosGenerales.get('tipoKilom').setValue(tipoKilom)
    this.f.datosGenerales.get('tipoComb').setValue(tipoComb)
    this.f.datosGenerales.get('nPlaca').setValue(placa)
  }

  avanzarTab() {
    switch (this.matTabs.selectedIndex) {
      case 0: {
        if (!this.inspeccionForm.get('datosGenerales').valid) {
          const invalidFields = [].slice.call(document.getElementsByClassName('ng-invalid'))
          invalidFields[1].focus()
        } else {
          this.matTabs.selectedIndex = this.matTabs.selectedIndex + 1
        }
        break
      }
      case 1: {
        if (!this.inspeccionForm.get('datosSalida').valid) {
          const invalidFields = [].slice.call(document.getElementsByClassName('ng-invalid'))
          invalidFields[1].focus()
        } else {
          this.matTabs.selectedIndex = this.matTabs.selectedIndex + 1
        }
        break
      }

      default: {
        this.matTabs.selectedIndex = this.matTabs.selectedIndex + 1
        break
      }

    }

  }

  formatLabel(value: number | null) {
    switch (value) {
      case 0: {
        return 'E'
        break
      }
      case 8: {
        return 'F'
        break
      }
      case 9: {
        return 'F+'
        break
      }
      default: {
        return value + '/8'
      }

    }
  }

  limpiarFirma() {
    this.firmaPad.clear()
  }

  limpiarDanios(){
    this.damagePad.clear()
    this.drawCarLine()
  }

  limpiarForm() {
    this.inspeccionForm.reset()
    this.matTabs.selectedIndex = 0
  }

  changePen(type){
    switch (type) {
      case 'quebradura':
        this.damagePad.penColor = '#ff0000'
        break

      case 'abolladura':
        this.damagePad.penColor = '#0008ff'
        break

      case 'rayon':
        this.damagePad.penColor = '#00ff1a'
        break
    }
  }

  drawCarLine(){
    const canvas = this.damagePadElement.nativeElement
    const ctx = canvas.getContext('2d')

    let img = new Image()
    img.crossOrigin = 'anonymous'
    img.src = 'assets/img/car-line-draw.png'
    img.onload = function () {
      // get the scale
      var scale = Math.min(canvas.width / img.width, canvas.height / img.height);
      // get the top left position of the image
      var x = (canvas.width / 2) - (img.width / 2) * scale;
      var y = (canvas.height / 2) - (img.height / 2) * scale;
      ctx.drawImage(img, x, y, img.width * scale, img.height * scale);

    }
  }

  onFormSubmit() {
    //const canvasElFirma: HTMLCanvasElement = this.canvasFirma.nativeElement
    const cFirmData = this.firmaPad.toDataURL("image/png")

    this.f.firma.get('firmaClienteSalida').setValue(cFirmData)

    const cDamageData = this.damagePad.toDataURL("image/png")
    this.f.danios.setValue(cDamageData)

    if (this.inspeccionForm.get('datosGenerales').valid && this.inspeccionForm.get('datosSalida').valid && this.inspeccionForm.get('firma').valid) {
      this.loading = true
      this.inspeccionesService.agregarInspeccion(this.inspeccionForm.value).subscribe(response => {
        if (response.error == 0) {
          this.loading = false
          this.router.navigate(['detail-inspeccion', response.data])
        }
      })
    }

  }



  increment(acc) {
    const increment = this.f.accesorios.get(acc).value + 1
    this.f.accesorios.get(acc).setValue(increment)
  }

  decrement(acc) {
    const decrement = this.f.accesorios.get(acc).value - 1
    this.f.accesorios.get(acc).setValue(decrement)
  }

  openResumeDialog(){
    this.dialog.open(ResumeDialogComponent,{
      data:{
        inspection: this.f,
        agencies: this.agencies
      }
    })
  }

  openConfirmDialog(){
    const dialogRef = this.dialog.open(ConfirmDialogComponent)
    dialogRef.afterClosed().subscribe(result=>{
      if(result == true){
        this.onFormSubmit()
      }
    })
  }


}
