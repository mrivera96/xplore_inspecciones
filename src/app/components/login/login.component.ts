import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { first } from 'rxjs/operators';
import {AuthenticationService} from '../../services/authentication.service';
declare var $: any;

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {
  loginForm: FormGroup;
  loading = false;
  submitted = false;
  returnUrl: string;
  error = '';

  constructor(
    private formBuilder: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private authenticationService: AuthenticationService,
  ) {
    // redirigir si el usuario no está logueado
    if (this.authenticationService.currentUserValue) {
      this.router.navigate(['/']);
    }
  }

  ngOnInit(): void {
    let nName = '';
    if (localStorage.getItem('remember_user')) {
      nName = localStorage.getItem('remember_user');
    }
    this.loginForm = this.formBuilder.group({
      nickName: [nName, Validators.required],
      password: ['', Validators.required],
      remember_me: ['']
    });

    // obtener la url de retorno desde los parámetros de la ruta o por defecto a '/'
    this.returnUrl = this.route.snapshot.queryParams.returnUrl || '/';
  }

  // getter para fácil acceso a los campos del formulario
  get f() { return this.loginForm.controls; }

  onSubmit() {
    this.submitted = true;

    // detener aquí si el formulario es inválido
    if (this.loginForm.invalid) {
      return;
    }

    if (this.f.remember_me.value) {
      localStorage.setItem('remember_user', this.f.nickName.value);
    }

    this.loading = true;
    this.authenticationService.login(this.f.nickName.value, this.f.password.value)
      .pipe(first())
      .subscribe(
        data => {
          this.router.navigate([this.returnUrl]);
        },
        error => {
          this.error = error;
          $("#errModal").modal('show');
          this.loading = false;
        });
  }

}
