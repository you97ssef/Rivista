import { Component, OnInit } from '@angular/core';
import { UserService } from 'src/app/services/user.service';

@Component({
  selector: 'app-profiles',
  templateUrl: './profiles.component.html',
  styleUrls: ['./profiles.component.scss'],
})
export class ProfilesComponent implements OnInit {
  profiles: any = null;

  constructor(private userService: UserService) {}

  ngOnInit(): void {
    this.getByLikes();
  }

  getByLikes() {
    this.userService.allByLikes().subscribe((response: any) => {
      this.profiles = response.data;
    });
  }

  getByViews() {
    this.userService.allByViews().subscribe((response: any) => {
      this.profiles = response.data.map((profile: any) => {
        let user = profile.user;
        user.views = profile.views;
        return user;
      });
    });
  }
}
