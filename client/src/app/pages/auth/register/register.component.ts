import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.scss']
})
export class RegisterComponent implements OnInit {
  credentials = {
    email: '',
    first_name: '',
    last_name: '',
    password: '',
    password_confirmation: ''
  };
  showPassword = false;

  constructor(private authService: AuthService, private router: Router) {}

  ngOnInit(): void {}

  showPasswordToggle() {
    this.showPassword = !this.showPassword;
  }

  register() {
    this.authService.register(this.credentials).subscribe((response: any) => {
      this.router.navigateByUrl('/');
    });
  }
}
