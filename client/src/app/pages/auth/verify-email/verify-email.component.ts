import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { ToastrService } from 'ngx-toastr';
import { AuthService } from 'src/app/services/auth.service';

@Component({
  selector: 'app-verify-email',
  templateUrl: './verify-email.component.html',
  styleUrls: ['./verify-email.component.scss'],
})
export class VerifyEmailComponent implements OnInit {
  verified = '';

  constructor(
    private route: ActivatedRoute,
    private toastr: ToastrService,
    private router: Router,
    private authService: AuthService
  ) {}

  ngOnInit(): void {
    let verify_url = this.route.snapshot.queryParamMap.get('verify_url');

    if (verify_url) {
      this.authService.verifyEmail(verify_url).subscribe((response: any) => {
        this.verified = response.message;
        let user = this.authService.getUser();
        user.email_verified_at = new Date();
        this.authService.setUser(user);
      });
    } else {
      this.toastr.error('Invalid verification link.');
      this.router.navigateByUrl('/');
    }
  }
}
