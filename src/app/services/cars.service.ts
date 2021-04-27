import { Injectable } from '@angular/core';
import { Car } from "../interfaces/car";
import { HttpClient, HttpParams } from "@angular/common/http";
import { User } from "../interfaces/user";
import { environment } from "../../environments/environment";
import { Observable } from "rxjs";
import { Response } from "../interfaces/response";
import { AuthenticationService } from './authentication.service';

@Injectable({
  providedIn: 'root'
})
export class CarsService {
  usuarioActual: User
  constructor(
    private http: HttpClient,
    private authService: AuthenticationService) {
    this.usuarioActual = this.authService.currentUserValue
  }

  public searchVehiculo(busqueda: string) {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        busqueda,
        function: 'buscarVehiculo',
        tkn: this.usuarioActual.access_token
      });
  }

  public getVehiculoData(nVehiculo: string) {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        nemVehiculo: nVehiculo,
        function: 'getDetalleVehiculo',
        tkn: this.usuarioActual.access_token
      });
  }

  public getTiposVehiculos() {
    return this.http.post<Response>(`${environment.apiUrl}`,
    {
      function: 'getTiposVehiculo',
      tkn: this.usuarioActual.access_token
    }
    );
  }

  public getTanquesComb() {
    return this.http.post<Response>(`${environment.apiUrl}`,
    {
      function: 'getTanques',
      tkn: this.usuarioActual.access_token
    }
    );
  }

  public getAccesorios() {
    return this.http.post<Response>(`${environment.apiUrl}`,
    {
      function: 'getAccesorios',
      tkn: this.usuarioActual.access_token
    }
    );
  }
}
