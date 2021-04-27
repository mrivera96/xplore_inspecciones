import { Injectable } from '@angular/core';
import { HttpClient } from "@angular/common/http";
import { Response } from "../interfaces/response";
import { environment } from "../../environments/environment";
import { AuthenticationService } from './authentication.service';
import { User } from '../interfaces/user';

@Injectable({
  providedIn: 'root'
})
export class AgenciesService {
  usuarioActual: User

  constructor(private http: HttpClient,
    private authService: AuthenticationService) {
    this.usuarioActual = this.authService.currentUserValue
  }

  getAgencias() {
    return this.http.post<Response>(`${environment.apiUrl}`,
      {
        function: 'getAgencias',
        tkn: this.usuarioActual.access_token
      });
  }
}
