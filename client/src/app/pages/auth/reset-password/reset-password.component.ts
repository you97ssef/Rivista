import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-reset-password',
  templateUrl: './reset-password.component.html',
  styleUrls: ['./reset-password.component.scss'],
})
export class ResetPasswordComponent implements OnInit {
  showPassword = false;
  credentials = {
    password: '',
    password_confirmation: '',
    email: '',
    token: '',
  };

  constructor(
    private toastr: ToastrService,
    private router: Router,
    private route: ActivatedRoute,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    let email = this.route.snapshot.queryParamMap.get('email');
    let token = this.route.snapshot.queryParamMap.get('token');

    if (email && token) {
      this.credentials.email = email;
      this.credentials.token = token;
    } else {
      this.toastr.error('Invalid link');
      this.router.navigateByUrl('/login');
    }
  }

  showPasswordToggle() {
    this.showPassword = !this.showPassword;
  }

  resetPassword() {
    this.authService
      .resetPassword(this.credentials)
      .subscribe((response: any) => {
        this.toastr.success(response.message);
        this.router.navigateByUrl('/login');
      });
  }
}
