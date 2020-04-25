import { Component, OnInit } from '@angular/core';
import { first } from 'rxjs/operators';

import {Usuario} from '../../interfaces/usuario';
import {UsuariosService} from '../../services/usuarios.service';
import {AuthenticationService} from '../../services/authentication.service';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})
export class HomeComponent implements OnInit {
  loading = false;
  users: Usuario[];

  constructor(private usuariosService: UsuariosService) { }

  ngOnInit(): void {
    this.loading = true;
  }

}
